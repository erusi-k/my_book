<template>
    <div class="body">
        <div class="other">
            <p class="heading">みんなの投稿</p>
            <carousel  :autoplay="true"   :per-page="3" :speed="3000" :autoplayTimeout="4000">
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
                                    <star-rating v-model="other.rating" read-only="true" star-size=20 ></star-rating>
                                </div>
                            </div>
                        </div>
                    </router-link>
                </slide>
            </carousel>
            
        </div>
        <div class="my_data">
            <p class="heading">自分の投稿</p>
            <div v-for="myData in myDatas" :key="myData.id">
                <div class="my_data-content">
                    <div class="my_data-content_image">
                        <img v-bind:src="myData.imge">
                    </div>
                    <div class="my_data-content_body">
                        <div class="my_data-content_body-title">
                            <p class="tag">タイトル</p>
                            <p class="content-main title">{{myData.title}}</p>
                        </div>
                        <div class="my_data-content_body-author">
                            <p class="tag">著者</p>
                            <p class="content-main author" >{{myData.author}}</p>
                        </div>
                        <div class="my_data-content_body-rating">
                            <p class="tag">評価</p>
                            <p class="content-main rating">{{myData.rating}}</p>
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
</template>

<script>
export default {
    props:['user'],
    
    data(){
        return{
            others:'',
            myDatas:'',
        }
        
    },
    methods:{
        async getOtherData(){
            await axios.get("http://localhost:8080/api/book/other/random",{params:{user_id:this.user.id}})
            .then((res)=>{
                this.others = res.data.data
                console.log('データ取得は動いています');
                console.log(this.others);
            })
            .catch((error) => {
                console.log(error);
                alert('失敗です');
            })
        },

        async getMyData(){
            await axios.get("http://localhost:8080/api/book/mydata",{params:{user_id:this.user.id}})
            .then((res) => {
                this.myDatas = res.data.data;
                console.log(this.myDatas);
            })
            .catch((error) => {
                console.log(error);
            })
        },

        

    },

    computed:{
            timeStamp:function(){
                return function(value) {
                    return value.substring(0,10);
                }
            }
        },
    
    created() {
        this.getOtherData();
        this.getMyData();
    }
}
</script>

<style scoped>

.body {
    font-family: 'Hannotate SC','Hiragino Kaku Gothic ProN','ヒラギノ角ゴ ProN W3','メイリオ', Meiryo,sans-serif;
}

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


.VueCarousel{
    
    width: 90%;
    margin: auto;
}

.VueCarousel-wrapper, .VueCarousel-inner, .VueCarousel-slide{
    height: 100% !important;
}

.VueCarousel-dot {
    background-color: red;
}

.VueCarousel-slide .slider-inner {
    height: 150px;
    width: 80%;
    margin: 2rem auto 2rem;
    padding: 1rem 0.5rem;
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
    width: 50%;
    height: 100%;
    /* padding: 0.2rem 0.5rem; */
}

.slider-title {
    font-size: 1rem;
    font-weight: bold;
    margin-left: 0.3rem;
}

.slider-author {
    font-size: 0.7rem;
    text-align: right;
}

.slider-header img {
    width: 100%;
    height: 100%;
}



.slider-footer {
    display: flex;
    font-size: 0.7rem; 
    margin-top: 1rem;
}

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
    height: 180px;
    background: #FFDBC9;
    padding: 0.2rem 0.5rem;
    margin: auto;
    margin-top: 2rem;
    box-shadow: 0px 0px 0px 10px #FFDBC9;
    border: 2px dashed #fff;
}

.my_data-content_body {
    margin: 1rem 0 0 6rem;
    width: 70%;
}

.my_data-content_image img {
    height: 100%;
}

.tag {
    font-size: 1rem;
    
}

.content-main {
    font-size: 2.3vmin;
    margin-left: 5rem;
}

.author, .rating {
    margin-left: 7rem;
}

.btn {
    display: flex;
    justify-content: center;
    align-items: center;
    width: 30%;
    height: 35px;
    background-color: #d6edff;
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



</style>