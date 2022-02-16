<template>
    <div class="body">
        <div class="top-btn" @click="scrollTop">
            <i class="fas fa-chevron-up Page-Btn-Icon"></i>
        </div>
        <div v-show="isLoading" class="loading">   
            <vue-loaders v-show='isLoading'  name ="ball-spin-fade-loader" color="#FF8856" scale="3"></vue-loaders>
        </div>
        <div>
            <div class="other">
                <p class="heading">みんなの投稿</p>
                <p class="not_data" v-show="!checkOtherData">投稿がありません</p>
                <div v-show="checkOtherData">
                    <carousel  :autoplay="true"   :per-page="page" :speed="3000" :autoplayTimeout="4000" pagination-color="#CCCCCC">
                        <slide class="slider" v-for="other in others" :key="other.id">
                            <router-link class="slider-show" :to="`/book/show/${other.id}`">
                                <div class="slider-inner">
                                    <div class="slider-header">
                                        <img v-bind:src="other.imge">
                                    </div>     
                                    <div class="slider-body"> 
                                        <p class="slider-title">{{other.title}}</p> 
                                        <p class="slider-author">作 {{other.author}}</p>
                                        <div class="slider-footer">
                                            <star-rating v-model="other.rating" :read-only="true" :star-size=20 ></star-rating>
                                        </div>
                                        <div class="slider-user">
                                            <p class="test">ユーザ名:{{other.user_name}}</p>
                                        </div>
                                    </div>
                                </div>
                            </router-link>
                        </slide>
                    </carousel>
                    <div class="list-link">
                        <router-link v-bind:to="{name: 'book.other'}">
                            <p class="list-link_btn">一覧表示する</p>
                        </router-link>
                    </div>
                </div>
            </div>
            <div v-show="!resp" class="my_data">
                <p class="heading">自分の投稿(最近の投稿）</p>
                <p class="not_data" v-show="!checkMyData">投稿がありません</p>
                <div v-show="checkMyData">
                    <div v-for="myData in myDatas" :key="myData.id">
                        <div class="my_data-content">
                            <div class="my_data-content_image">
                                <img v-bind:src="myData.imge">
                            </div>
                            <div class="my_data-content_body">
                                <div class="my_data-content_body-title">
                                    <p class="tag">タイ<br>トル</p>
                                    <p class="content-main title">{{myData.title}}</p>
                                </div>
                                <div class="my_data-content_body-author">
                                    <p class="tag">著者</p>
                                    <p class="content-main author" >{{myData.author}}</p>
                                </div>
                                <div class="my_data-content_body-rating">
                                    <p class="tag">評価</p>
                                    <star-rating class="content-main rating" v-model="myData.rating" :read-only="true" :star-size=30 ></star-rating>
                                </div>
                                <div class="my_data-content_body-footer">
                                    <p class="tag">{{timeStamp(myData.created_at)}}</p>
                                    <router-link class="btn" :to="`/book/show/${myData.id}`" >詳細へ</router-link>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="list-link">
                        <router-link v-bind:to="{name: 'book.mylist'}">
                            <p class="list-link_btn">一覧表示する</p>
                        </router-link>
                    </div>
                </div>
                <div v-show="!checkMyData" class="list-link">
                    <router-link v-bind:to="{name: 'book.create'}">
                        <p class="list-link_btn">感想を書いてみましょう！</p>
                    </router-link>
                </div>
            </div>
            <div v-show="resp" class="responsive">
                <p class="heading">自分の投稿(最近の投稿）</p>
                <p class="not_data" v-show="!checkMyData">投稿がありません</p>
                <div v-show="checkMyData">
                    <div class="responsive_my-data" v-for="myData in myDatas" :key="myData.id">
                        <router-link class="responsive_my-data-show" :to="`/book/show/${myData.id}`">
                            <div class="responsive_my-data_inner">
                                <div class="responsive_my-data_inner-header">
                                    <img v-bind:src="myData.imge">
                                </div>     
                                <div class="responsive_my-data_body"> 
                                    <p class="responsive_my-data_body-title">{{myData.title}}</p> 
                                    <p class="responsive_my-data_body-author">作 {{myData.author}}</p>
                                    <div class="responsive_my-data_body-footer">
                                        <star-rating v-model="myData.rating" :read-only="true" :star-size=20 ></star-rating>
                                    </div>
                                </div>
                            </div>f
                        </router-link>
                    </div>
                    <div class="list-link">
                        <router-link v-bind:to="{name: 'book.mylist'}">
                            <p class="list-link_btn">一覧表示する</p>
                        </router-link>
                    </div>
                </div>    
                <div v-show="!checkMyData" class="list-link">
                    <router-link v-bind:to="{name: 'book.create'}">
                        <p class="list-link_btn">感想を書いてみましょう！</p>
                    </router-link>
                </div>
            </div>
        </div>    
    </div>
</template>

<script>
export default {
    props:['user'],
    data(){
        return{
            others:'',
            checkOtherData: '',
            checkMyData: '',
            myDatas:'',
            isLoading: true,
            page: 3,
            resp: false,
            
        } 
    },
    methods:{

    // みんなのデータ取得    
        async getOtherData(){
            const baseUrl = process.env.MIX_API_URL
            await axios.get(`${baseUrl}/other/random`,{params:{user_id:this.user.id}})
            .then((res)=>{
                this.others = res.data.data
                if(!this.others.length == 0){
                    this.checkOtherData = true;
                } else {
                    this.checkOtherData = false;
                }
                console.log(this.others);
                this.isLoading = false;
            })
            .catch((error) => {
                console.log(error);
                alert('みんなの投稿のデータ取得に失敗しました');
            })
        },

    // 自分のデータ取得
        async getMyData(){
            const baseUrl = process.env.MIX_API_URL
            await axios.get(`${baseUrl}/new_mydata`,{params:{user_id:this.user.id}})
            .then((res) => {
                this.myDatas = res.data.data;
                if(!this.myDatas.length == 0) {
                    this.checkMyData = true;
                } else {
                    this.checkMyData = false;
                }
                console.log(this.myDatas.length);
                console.log(this.myDatas);
                console.log(this.checkMyData);
            })
            .catch((error) => {
                console.log(error);
            })
            console.log(this.baseUrl);
        },

    // 画面幅検知
        handleResize(){
            if(window.innerWidth <= 480){
                this.page = 1;
                this.resp = true;
            }else if(window.innerWidth <= 705) {
                this.page = 1;
            }else if(window.innerWidth <= 1024) {
                this.page = 2;
                this.resp = true;
            }else {
                this.page = 3;
                this.resp = false;
            } 
        },

    //topに戻るボタン
        scrollTop(){
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        }
    },

    computed:{
            timeStamp:function(){
                return function(value) {
                    return value.substring(0,10);
                }
            }
        },
    
    created() {
        window.addEventListener('resize',this.handleResize);
        this.handleResize();
        this.getOtherData();
        this.getMyData();
    }
}
</script>

<style scoped>

.body {
    font-family: 'Avenir','Arial Rounded MT Bold','Comic Sans MS','Hannotate SC','Hiragino Kaku Gothic ProN','ヒラギノ角ゴ ProN W3','Yu Gothic UI',sans-serif;
}

/* topに戻るボタン */
.top-btn {
    color: #fff;
    position: fixed;
    right: 14px;
    bottom: 35px;
    width: 32px;
    height: 32px;
    line-height: 32px;
    text-align: center;
    border-radius: 50%;
    background: #5bc8ac;
}

/* ローディングぐるぐる */
.loading {
    position:fixed;
    top:0;
    left:0;
    width: 100%;
    height: 100%;
    background-color: rgba(255,255,255,1);
    z-index: 80;
    display: flex;
    align-items: center;
    justify-content: center;

}

/* 投稿がありません */
.not_data {
    color: #999999;
    font-size: 1.5rem;
    text-align: center;
    margin-top: 3rem;
}

/* 見出し */
.heading {
    display: inline-block;
    font-weight: bold;
    font-size: 1.5rem;
    border-bottom: 2px solid #fff;
}

.heading:first-letter {
    color: #FF5F17;
    font-size: 3rem;
}


/* スライダー */
.VueCarousel{
    width: 90%;
    margin: auto;
}

.VueCarousel-wrapper, .VueCarousel-inner, .VueCarousel-slide{
    height: 100% !important;
}

.pagination
.VueCarousel-dot {
    background-color: red;
}

.VueCarousel-slide .slider-inner {
    height: 180px;
    width: 80%;
    margin: 2rem auto 2rem;
    padding: 0.2rem 0.5rem;
    background-color: #d6edff; 
    display: flex; 
    color: #000; 
    box-shadow: 0px 0px 0px 10px #d6edff;
    border: 2px dashed #fff;
    font-size: 30px; 
    border-radius: 10px;
}

.slider-inner:hover {
    transform: translateY(-3px);
    box-shadow: 0 7px 14px rgba(50,50,93,1), 0 3px 6px rgba(0,0,0,.08);
    transition: all .5s;
}

.slider-header {
    width: 40%;
    height: 100%;
}

.slider-body {
    width: 50%;
    margin-left: 0.6rem;
}

.slider-title {
    font-size: 1rem;
    font-weight: bold;
    margin-left: 0.3rem;
}

.slider-author {
    font-size: 0.8rem;
    text-align: right;
}

.slider-header img {
    width: 100%;
    height: 100%;
}



.slider-footer {
    display: flex;
    font-size: 0.7rem; 
    margin-top: 0.6rem;
}

.slider-user {
    margin-top: 0.6rem;
    text-align: right;
    font-size: 0.8rem;
}


/* 自分の投稿 */
.my_data-content,.my_data-content_body-title, 
.my_data-content_body-author,.my_data-content_body-rating {
    display: flex;
    margin-top: 0.6rem;
    border-bottom: 1px dashed #fff;
}

.my_data-content_body-footer {
    display: flex;
    margin-top: 0.6rem;
    justify-content: space-between;
}

.my_data {
    width: 100%;
    margin-top: 5rem;
}

.my_data-content {
    width: 900px;
    height: 220px;
    background: #FFDBC9;
    padding: 0.2rem 0.5rem;
    margin: auto;
    margin-top: 5rem;
    box-shadow: 0px 0px 0px 10px #FFDBC9;
    border: 2px dashed #fff;
}

.my_data-content_body {
    margin: 1rem 0 0 6rem;
    width: 70%;
}

.my_data-content_image {
    width: 15%;
}

.my_data-content_image img {
    width: 100%;
    height: 100%;
}

.tag {
    font-size: 1rem;
    width: 15%;
}

.content-main {
    font-size: 2.3vmin;
    margin-left: 5rem;
}

.title,.author, .rating {
    margin-left: 7rem;
}

.btn {
    display: flex;
    justify-content: center;
    align-items: center;
    width: 30%;
    height: 35px;
    background-color: #FF5F17;
    box-sizing: border-box;
    color: #fff;
    font-size: 16px;
    letter-spacing: 0.1em;
    line-height: 2.0;
    text-decoration: none;
    transition-duration: 0.3s;
    position: relative;
}

.btn:before {
    content: "";
    position: absolute;
    top: 0;
    left: 0;
    width: 0;
    height: 0;
    border-style: solid;
    border-width: 15px 20px 0 0;
    border-color: #ffffff transparent transparent transparent;
}

.btn:after {
    content: "";
    position: absolute;
    top: -6px;
    left: 5px;
    width: 0;
    height: 0;
    border-style: solid;
    border-width: 0 0 20px 15px;
    border-color: transparent transparent #efefef transparent;
    box-shadow: 1px 1px 1px 0px rgba(0, 0, 0, 0.15);
    transform: rotate(16deg);
}

.btn:hover {
    background-color: #e6de6b;
}

.btn span {
    position: relative;
    padding-left: 16px;
    letter-spacing: 0.05em;
}

.btn span:before {
    content: '';
    width: 6px;
    height: 6px;
    border: 0;
    border-top: solid 2px #fff;
    border-right: solid 2px #fff;
    transform: rotate(45deg);
    position: absolute;
    top: 50%;
    left: 0;
    margin-top: -4px;
}


/* 投稿を書いてみましょう,一覧表示 */
.list-link {
    display: flex;
    justify-content: flex-end;
}

.list-link_btn {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-top: 2rem;
    margin-right: 3rem;
    padding: 1rem 2rem;
    width: 180px;
    color: #fff;
    font-size: 0.8rem;
    background-color: #FF6600;
    transition: 0.3s;
}

.list-link_btn::after {
    content: '';
    width: 7px;
    height: 7px;
    border-top: 3px solid #333333;
    border-right: 3px solid #333333;
    transform: rotate(45deg);
}

.list-link_btn:hover {
    text-decoration: none;
    background-color: #bbbbbb;
}

/* mydataレスポンシブ */
.responsive {
    margin-top: 5rem;
}

.responsive_my-data_inner {
    height: 155px;
    width: 75%;
    margin: 5rem auto 2rem;
    padding: 0.2rem 0.5rem;
    background-color: #FFDBC9; 
    display: flex; 
    color: #000; 
    box-shadow: 0px 0px 0px 10px #FFDBC9;
    border: 2px dashed #fff;
    font-size: 30px; 
    border-radius: 10px;
}

.responsive_my-data_inner:hover {
    transform: translateY(-3px);
    box-shadow: 0 7px 14px rgba(50,50,93,1), 0 3px 6px rgba(0,0,0,.08);
    transition: all .5s;
}

.responsive_my-data_inner-header {
    width: 40%;
    height: 100%;
    /* padding: 0.2rem 0.5rem; */
}

.responsive_my-data_inner-header img {
    width: 100%;
    height: 100%;
}

.responsive_my-data_body {
    width: 50%;
    margin-left: 0.6rem;
}

.responsive_my-data_body-title {
    font-size: 1rem;
    font-weight: bold;
    margin-left: 0.3rem;
}

.responsive_my-data_body-author {
    font-size: 0.8rem;
    text-align: right;
}

.responsive_my-data_body-footer {
    display: flex;
    font-size: 0.7rem; 
    margin-top: 0.6rem;
}



@media screen and (max-width: 1024px) {
    body {
        margin-top: 5rem;
    }

    .responsive_my-data_inner-header img {
        width: 70%;
    }

    .responsive_my-data_body-title {
        margin-top: 1rem;
        font-size: 1.1rem
    }

    .responsive_my-data_body-author {
        font-size: 0.9rem;
    }

    .responsive_my-data_body-footer {
        font-size: 0.8rem; 
    }
}

@media screen and (max-width: 480px) {
    body {
        margin-top: 5rem;
    }

    .responsive_my-data_body-title {
        margin-top: 0.3rem;
        font-size: 1rem
    }

    .responsive_my-data_body-author {
        font-size: 0.8rem;
    }

    .responsive_my-data_body-footer {
        font-size: 0.7rem; 
    }
}


</style>