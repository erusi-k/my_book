<template>
    <div>
        <p>みなさんでーた表示リスto</p>
        <div class="other">
            <p>みんなの投稿 </p>
            <div>
                <div v-for="other in others" :key="other.id">
                    <div >
                        <div>
                            <img  v-bind:src="other.imge" alt="">
                        </div>     
                        <div> 
                            <p>{{other.title}}</p> 
                            <p>作 {{other.author}}</p>
                            <div>
                                <p>{{other.rating}}</p>
                                <router-link class="slider-show" :to="`/book/show/${other.id}`">詳細を見る</router-link>
                            </div>
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

    created(){
        this.getOtherData();
    }
}
</script>