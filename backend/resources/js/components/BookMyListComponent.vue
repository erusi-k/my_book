<template>
    <div class="body">
        <div class="bod">
            <div class="top-btn" @click="scrollTop">
                <i class="fas fa-chevron-up Page-Btn-Icon"></i>
            </div>
            <div v-show="isLoading" class="loading">   
                <vue-loaders v-show='isLoading'  name ="ball-spin-fade-loader" color="#FF8856" scale="3"></vue-loaders>
            </div>
            <div v-show="!resp">
                <p class="heading">自分の投稿</p>
                <p class="not_data" v-show="!checkMyData">投稿がありません</p>
                <div v-show="checkMyData">
                    <div v-for="myData in myDatas" :key="myData.id">
                        <div>
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
                    </div>
                </div>      
            </div>
            <div class="my_data">
                <div v-show="resp" class="responsive">
                    <p class="heading">自分の投稿</p>
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
                                </div>
                            </router-link>
                        </div>
                    </div>    
                </div>  
                <div class="new">
                    <router-link v-bind:to="{name: 'book.create'}">
                        <p class="new_btn" v-show="!checkMyData">感想を書いてみる！</p>
                    </router-link>
                </div>
            </div>
        </div>
    </div>    
</template>


<script>
export default({
    props:['user'],
    data(){
        return{
            myDatas: '',
            isLoading: true,
            resp: false,
            checkMyData: '',
        }
    },
    
    methods: {

    // データ取得    
        async getMyData(){
            const baseUrl = process.env.MIX_API_URL;
            await axios.get(`${baseUrl}/mydata`,{params:{user_id:this.user.id}})
            .then((res) => {
                this.myDatas = res.data.data;
                if(!this.myDatas.length == 0) {
                    this.checkMyData = true;
                } else {
                    this.checkMyData = false;
                }
                console.log(this.myDatas);
                this.isLoading = false;
            })
            .catch((error) => {
                console.log(error);
            })
        },

    //画面幅検知
        handleResize(){
            if(window.innerWidth <= 1024){
                this.resp = true;
            }else {
                this.resp = false;
            }
        },

    //topに戻る処理
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
        this.getMyData();
    }    
})
</script>

<style>

body {
    font-family: 'Avenir','Arial Rounded MT Bold','Comic Sans MS','Hannotate SC','Hiragino Kaku Gothic ProN','ヒラギノ角ゴ ProN W3','Yu Gothic UI',sans-serif;
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


/* 投稿データ */
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
}

.my_data-content {
    width: 900px;
    height: 210px;
    background: #FFDBC9;
    padding: 0.2rem 0.5rem;
    margin: auto;
    margin-top: 6rem;
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
    margin-left: 3rem;
}

.title {
    padding: 0.1rem;
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


/* 感想を書いてみましょう！ */
.new {
    text-align: center;
}

.new_btn {
    font-size: 18px;
    display: inline-block;
    margin-top: 5rem;
    padding: 0.5rem 1rem 0.3rem;
    position: relative;
    color: #990000;
    border: solid 2px #990000;
    border-radius: 5px;
    background-color: transparent;
    cursor: pointer;
    animation: fluffy1 3s ease infinite;
}

.new_btn:before {
    background-color: #FF9966;
    border-radius: 5px;
    content: "";
    width: 100%;
    height: 100%;
    position: absolute;
    left: 5px;
    top: 5px;
    z-index: -1;
    animation: fluffy1 3s ease infinite;
}

@keyframes fluffy1 {
    0% { transform:translateY(0) }
    5% { transform:translateY(0) }
    10% { transform:translateY(0) }
    20% { transform:translateY(-15px) }
    25% { transform:translateY(0) }
    30% { transform:translateY(-15px) }
    50% { transform:translateY(0) }
    100% { transform:translateY(0) }
}

/* mydataレスポンシブ */
.responsive_my-data_inner {
    height: 155px;
    width: 75%;
    margin: 5rem auto 4rem;
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
    width: 30%;
    height: 100%;
}

.responsive_my-data_inner-header img {
    width: 100%;
    height: 100%;
}

.responsive_my-data_body {
    width: 70%;
    margin-left: 0.3rem;
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
    .body {
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
    .bod {
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