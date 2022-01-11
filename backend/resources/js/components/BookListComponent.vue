<template>
    <div class="content">
        <div class="other">
            <p>みんなの投稿 </p>
            <carousel class="slider"   :per-page="3" :speed="3000" :autoplayTimeout="4000">
                <slide v-for="other in others" :key="other.id">
                    <div class="slider-inner">
                        <div class="slider-header">
                            <img class="slider-image" v-bind:src="other.imge" alt="">
                        </div>     
                        <div class="slider-body"> 
                            <p class="slider-title">{{other.title}}</p> 
                            <p class="slider-author">作 {{other.author}}</p>
                            <div class="slider-footer">
                                <p class="slider-rating">{{other.rating}}</p>
                                <router-link class="slider-show" :to="`/book/show/${other.id}`">詳細を見る</router-link>
                            </div>
                        </div>
                    </div>
                </slide>
            </carousel>
        </div>
        <div class="my_data">
            <p>自分の投稿</p>
            <div v-for="myData in myDatas" :key="myData.id">
                <div class="my_data-content">
                    <div class="my_data-content_image">
                        <img v-bind:src="myData.imge">
                    </div>
                    <div class="my_data-content_body">
                        <div class="my_data-content_body-title">
                            <p>タイトル</p>
                            <p>{{myData.title}}</p>
                        </div>
                        <div class="my_data-content_body-author">
                            <p>著者</p>
                            <p>{{myData.author}}</p>
                        </div>
                        <div class="my_data-content_body-rating">
                            <p>評価</p>
                            <p>{{myData.rating}}</p>
                        </div>
                        
                    </div>
                </div>
                
                <router-link :to="`/book/show/${myData.id}`" >詳細を見る</router-link>
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
            await axios.get("http://localhost:8080/api/book/other",{params:{user_id:this.user.id}})
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
        }
    },
    created() {
        this.getOtherData();
        this.getMyData();
    }
}
</script>

<style scoped>

.content {
    background: #FAEBD7;
}

.VueCarousel{
    height: 300px;
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
    height: 100%;
    width: 80%;
    margin: auto;
    background-color: #fff; 
    display: flex; 
    justify-content: center; 
    align-items: center; 
    color: #000; 
    border: 2px solid #fff;
    font-size: 30px; 
    border-radius: 10px;
}

.slider-inner:hover {
    transform: translateY(-3px);
    box-shadow: 0 7px 14px rgba(50,50,93,1), 0 3px 6px rgba(0,0,0,.08);
    transition: all .5s;
}

.slider-header {
    flex-shrink: 0;
    width: 40%;
    margin-right: auto;
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

.slider-image {
    width: 100%;
    height: 150px;
    border-top-left-radius: 10px;
    border-bottom-left-radius: 10px;
}



.slider-footer {
    display: flex;
    font-size: 0.7rem; 
}

.my_data-content,.my_data-content_body-title, 
.my_data-content_body-author,.my_data-content_body-rating {
    display: flex;
}




</style>