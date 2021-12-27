<template>
    <div>
        <form v-on:submit.prevent="submit">
            <input type="text" v-model="item.title">
            <input type="text" v-model="item.author">
            <input type="text" v-model="item.report">
            <star-rating v-model="item.rating" v-bind:increment="0.5"></star-rating>
            <button type="submit">更新する</button>
        </form>
    </div>
</template>

<script>
export default ({
    props:['user','bookId'],
    data(){
        return{
            item:'',
            rating:'',
        }
    },
    methods:{
        checkId(id){
            if(this.user_id !== id) {
                alert('IDはあってません')
            }
        },
        getData() {
            const id = this.bookId;
            axios.get("http://localhost:8080/api/book/"+id)
            .then((res) => {
                console.log(res.data.data);
                this.item = res.data.data;
                this.rating = res.data.data.rating;
            })
            .catch((error) => {
                console.log(error);
                alert('データ所得失敗です');
            })
        },
        submit(){
            const flag = confirm("こちらの内容で更新しますか?")

            if(flag == true){
                this.item.rating = this.rating;
                axios.put("http://localhost:8080/api/book/" +this.bookId,this.item)
                .then((res) => {
                    console.log(res);
                    alert('更新に成功しました');
                    this.$router.push({name: 'book.list'});
                })
                .catch((error) => {
                    console.log(error);
                    alert('更新に失敗しました');
                })
            }
        }
    },
    mounted(){
        this.checkId();
    },
    created(){
        this.getData();
    }
})
</script>