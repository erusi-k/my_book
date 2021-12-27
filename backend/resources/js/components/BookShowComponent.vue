<template>
<div>
    <p>詳細テスト</p>
    <div v-for="item in items" :key="item.id">
        <p>{{item.title}}</p>
        <p>{{item.author}}</p>
        <p>{{item.report}}</p>
        <star-rating v-model="item.rating" v-bind:increment="0.5" read-only="true"></star-rating>
        <router-link :to="`/book/edit/${item.id}`" v-if="checkId(item.user_id)">編集する</router-link>
        <router-link :to="`/book/edit/${item.id}`" v-if="checkId(item.user_id)">削除する</router-link>
    </div>
    <p>{{user.id}}</p>
</div>    
</template>

<script>
export default ({
    props:['bookId','user'],
    data(){
        return {
            items:'',
        }
    },
    methods:{
        getData() {
            const id = this.bookId
            axios.get("http://localhost:8080/api/book/"+id)
            .then((res) => {
                
                this.items = res.data;
                console.log(this.items);
            })
            .catch((error) => {
                console.log(error);
            })
        },
        checkId(user_id){
            if(this.user.id == user_id){
                return true;
            }
            return false;
            
        }
        
    },

    computed:{

        
    },

    mounted(){
        this.checkId();
    },


    created(){
        this.getData();
    }
})
</script>