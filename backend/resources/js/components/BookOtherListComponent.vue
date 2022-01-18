<template>
    <div class="body">
        <p>みなさんでーた表示リスto</p>
        <div class="other">
            <p>みんなの投稿 </p>
            <div v-for="other in others" :key="other.id">
                <div class ="other_data" >
                    <div class="other_data-image">
                        <img  v-bind:src="other.imge" alt="">
                    </div>     
                    <div class="other_data_body"> 
                        <div class="other_data_body-title">
                            <p class="tag">タイトル</p>
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
                            <router-link class="content-main btn"  :to="`/book/show/${other.id}`">詳細を見る！</router-link>
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
        }
        
    },

    methods:{
        async getOtherData(){
            await axios.get("http://localhost:8080/api/book/other/all",{params:{user_id:this.user.id}})
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
    },

    computed:{
            timeStamp:function(){
                return function(value) {
                    return value.substring(0,10);
                }
            }
        },

    created(){
        this.getOtherData();
    }
}
</script>

<style scoped>

.body {
    font-family: 'Hannotate SC','Hiragino Kaku Gothic ProN','ヒラギノ角ゴ ProN W3','メイリオ', Meiryo,sans-serif;
}

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
    height: 180px;
    background: #d6edff;
    padding: 0.2rem 0.5rem;
    margin: auto;
    margin-top: 2rem;
    box-shadow: 0px 0px 0px 10px #d6edff;
    border: 2px dashed #fff;
}

.other_data_body {
    margin: 1rem 0 0 6rem;
    width: 70%;
}

.other_data-image img {
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
    background-color: #FFDBC9;
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