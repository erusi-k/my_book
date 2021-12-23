<template>
    <div>
        <div v-for="item in items" :key="item.id">  
                {{item.title}}
                {{item.author}}
                {{item.rating}}
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
            userId:1
        }
        
    },
    methods:{
        async getData(){
            await axios.get("http://localhost:8080/api/book")
            .then((res)=>{
                this.items = res.data.data
                console.log(this.items);
            })
            .catch((error) => {
                console.log(error);
                alert('失敗です');
            })
        }
    },
    created() {
        this.getData();
    }
}
</script>