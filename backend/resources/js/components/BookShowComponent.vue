<template>
<div>
    <div v-for="item in items" :key="item.id">
        <p>{{item.title}}</p>
        <p>{{item.author}}</p>
        <p>{{item.report}}</p>
        <p>{{item.user_id}}</p>
        <star-rating v-model="item.rating" v-bind:increment="0.5" read-only="true"></star-rating>
        <p v-if="checkId(item.user_id)">編集する</p>
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