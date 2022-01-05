<template>
    <div>
        <div v-for="item in items" :key="item.id">  
                {{item.title}}
                {{item.author}}
                {{item.rating}}
                <img v-bind:src="item.imge" alt="">
                <router-link :to="`/book/show/${item.id}`">詳細へ</router-link>
        </div>
    </div>
</template>

<script>
export default {
    props:['user'],
    
    data(){
        return{
            items:'',
        }
        
    },
    methods:{
        async getOtherData(){
            const id  = this.user.id;
            await axios.get("http://localhost:8080/api/book/other"+id)
            .then((res)=>{
                this.items = res.data.data
                console.log('データ取得は動いています');
                console.log(this.items);
            })
            .catch((error) => {
                console.log(error);
                alert('失敗です');
            })
        }
    },
    created() {
        this.getOtherData();
    }
}
</script>