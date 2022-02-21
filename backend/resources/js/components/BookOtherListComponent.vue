<template>
    <div class="body">
        <div class="top-btn" @click="scrollTop">
            <i class="fas fa-chevron-up Page-Btn-Icon"></i>
        </div>
        <div v-show="isLoading" class="loading">   
            <vue-loaders v-show='isLoading'  name ="ball-spin-fade-loader" color="#FF8856" scale="3"></vue-loaders>
        </div>
        <div v-show="!resp" class="other">
            <p class="heading">みんなの投稿 </p>
            <p class="not_data" v-show="!checkOtherData">投稿がありません</p>
            <div v-show="checkOtherData">
                <div v-for="other in others" :key="other.id">
                    <div class ="other_data" >
                        <div class="other_data-image">
                            <img  v-bind:src="other.imge" alt="">
                        </div>     
                        <div class="other_data_body"> 
                            <div class="other_data_body-title">
                                <p class="tag">タイ<br>トル</p>
                                <p class="content-main title">{{other.title}}</p> 
                            </div>
                            <div class="other_data_body-author" >
                                <p class="tag">著者</p>
                                <p class="content-main author">作 {{other.author}}</p>
                            </div>
                            <div class="other_data_body-rating">
                                <p class="tag">評価</p>
                                <p class="content-main rating">{{other.rating}}</p>
                            </div>
                            <div class="other_data_body-footer">
                                <p class="tag">{{timeStamp(other.created_at)}}</p>
                                <p class="other_data_body-footer-name name">ユーザー名:{{other.user_name}}</p>
                                <router-link class="content-main btn"  :to="`/book/show/${other.id}`">詳細を見る！</router-link>
                            </div>    
                        </div>
                    </div>
                </div>
                <div class="api-loading" ref="observe_element" >
                    <vue-loaders v-show='apiLoading' name ="ball-beat" color="#FF8856" scale="2"></vue-loaders>
                </div>
            </div>    
        </div>
        <div>
            <div v-show="resp" class="responsive">
                <p class="heading">みんなの投稿</p>
                <p class="not_data" v-show="!checkOtherData">投稿がありません</p>
                <div v-show="checkOtherData">
                    <div class="responsive_other" v-for="other in others" :key="other.id">
                        <router-link class="responsive_other-show" :to="`/book/show/${other.id}`">
                            <div class="responsive_other_inner">
                                <div class="responsive_other_inner-header">
                                    <img v-bind:src="other.imge">
                                </div>     
                                <div class="responsive_other_body"> 
                                    <p class="responsive_other_body-title">{{other.title}}</p> 
                                    <p class="responsive_other_body-author">作 {{other.author}}</p>
                                    <div class="responsive_other_body-footer">
                                        <star-rating v-model="other.rating" :read-only="true" :star-size=20 ></star-rating>
                                    </div>
                                    <p class="responsive_other_body-name name">ユーザー名:{{other.user_name}}</p>
                                </div>
                            </div>
                        </router-link>
                    </div>
                    <div class="api-loading" ref="resp_observe_element" >
                        <vue-loaders v-show='apiLoading' name ="ball-beat" color="#FF8856" scale="2"></vue-loaders>
                    </div>
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
            isLoading: true,
            apiLoading: true,
            resp: false,
            checkOtherData: '',
            page: 1,
            observe: '',
            respObserve:'',
        }
    },

    methods:{

    // データ取得    
        async getOtherData(){
            const baseUrl = process.env.MIX_API_URL;
            await axios.get(`${baseUrl}/other?page=${this.page++}`,{params:{user_id:this.user.id}})
            .then((res)=>{
                if(res.data.data.data == 0){
                    this.apiLoading = false;
                }
                this.others = [...this.others,...res.data.data.data];
                if(!this.others.length == 0) {
                    this.checkOtherData = true;
                } else {
                    this.checkOtherData = false;
                }
                this.isLoading = false;
                console.log(this.others);
            })
            .catch((error) => {
                console.log(error);
                alert('失敗です');
            })
        },

    // 画面幅検知
        handleResize(){
            if(window.innerWidth <= 1024){
                this.resp = true;
            }else {
                this.resp = false;
            }
        },

    // topに戻る処理
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

    created(){
        window.addEventListener('resize',this.handleResize);
        this.handleResize();
        this.getOtherData();
    },

    mounted(){
        this.observer = new IntersectionObserver(entries => {
            const entry = entries[0];
            if(entry && entry.isIntersecting) {
                this.getOtherData();
            }
        })
        const observe_element = this.$refs.observe_element;
        this.observer.observe(observe_element);

        this.respObserver = new IntersectionObserver(entries => {
            const entry = entries[0];
            if(entry && entry.isIntersecting) {
                this.getOtherData();
            }
        })
        const resp_observe_element = this.$refs.resp_observe_element;
        this.respObserver.observe(resp_observe_element);
    }
}
</script>

<style scoped>

.body {
    font-family: 'Avenir','Arial Rounded MT Bold','Comic Sans MS','Hannotate SC','Hiragino Kaku Gothic ProN','ヒラギノ角ゴ ProN W3','Yu Gothic UI',sans-serif;
}

/* topに戻る */
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

/* データ取得ローディング */
.api-loading {
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 4rem 0;
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

/* みんなのデータ */
.other_data,.other_data_body-title, 
.other_data_body-author,.other_data_body-rating
{
    display: flex;
    margin-top: 0.6rem;
    border-bottom: 1px dashed #fff;

}

.other_data_body-footer {
    display: flex;
    margin-top: 0.6rem;
    justify-content: space-between;

}

.other {
    width: 100%;
}

.other_data {
    width: 900px;
    height: 210px;
    background: #d6edff;
    padding: 0.2rem 0.5rem;
    margin: auto;
    margin-top: 6rem;
    box-shadow: 0px 0px 0px 10px #d6edff;
    border: 2px dashed #fff;
}

.other_data_body {
    margin: 1rem 0 0 6rem;
    width: 70%;
}

.other_data-image {
    width: 15%;
}

.other_data-image img {
    width: 100%;
    height: 100%;
}

.tag {
    font-size: 1rem;
    width: 20%;
}

.content-main {
    font-size: 2.3vmin;
    margin-left: 5rem;
}

.title,.author, .rating {
    margin-left: 7rem;
}

.name {
    background:linear-gradient(transparent 30%, #FFCCCC 60%);
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

/* otherレスポンシブ */
.responsive_other_inner {
    height: 190px;
    width: 75%;
    margin: 5rem auto 4rem;
    padding: 0.2rem 0.5rem;
    background-color: #d6edff; 
    display: flex; 
    color: #000; 
    box-shadow: 0px 0px 0px 10px #d6edff;
    border: 2px dashed #fff;
    font-size: 30px; 
    border-radius: 10px;
}

.responsive_other_inner:hover {
    transform: translateY(-3px);
    box-shadow: 0 7px 14px rgba(50,50,93,1), 0 3px 6px rgba(0,0,0,.08);
    transition: all .5s;
}

.responsive_other_inner-header {
    width: 40%;
    height: 100%;
    /* padding: 0.2rem 0.5rem; */
}

.responsive_other_inner-header img {
    width: 100%;
    height: 100%;
}

.responsive_other_body {
    width: 50%;
    margin-left: 0.6rem;
}

.responsive_other_body-name {
    display: inline-block;
    font-size: 0.8rem;
    margin-top: 0.5rem;
}

.responsive_other_body-title {
    font-size: 1rem;
    font-weight: bold;
    margin-left: 0.3rem;
    display: -webkit-box;
    font-size: 1rem;
    font-weight: bold;
    margin-left: 0.3rem;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.responsive_other_body-author {
    font-size: 0.8rem;
    text-align: right;
}

.responsive_other_body-footer {
    display: flex;
    font-size: 0.7rem; 
    margin-top: 0.6rem;
}

@media screen and (max-width: 1024px) {
    body {
        margin-top: 5rem;
    }

    .responsive_other_inner-header img {
        width: 70%;
    }

    .responsive_other_body-title {
        margin-top: 1rem;
        font-size: 1.1rem
    }

    .responsive_other_body-author {
        font-size: 0.9rem;
    }

    .responsive_other_body-footer {
        font-size: 0.8rem; 
    }
}

@media screen and (max-width: 600px) {
    body {
        margin-top: 5rem;
    }

    .responsive_other_body-title {
        margin-top: 0.3rem;
        font-size: 1rem
    }

    .responsive_other_body-author {
        font-size: 0.8rem;
    }

    .responsive_ohter_body-footer {
        font-size: 0.7rem; 
    }
}

</style>