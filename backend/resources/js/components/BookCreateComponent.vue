<template>
    <div>
        <form v-on:submit.prevent="submit">
            <div>
                <lable for="title">タイトル</lable>
                <input type="text" id="title" v-model="data.title">
            </div>
            <div>
                <lable for="author">著者</lable>
                <input type="text" id="author" v-model="data.author">
            </div>
            <div>
                <lable for="report">感想</lable>
                <input type="text" id="report" v-moder="data.report">
            </div>
            <button type="submit">登録</button>
        </form>
        
    </div>
</template>

<script>
    export default {
        data(){
            return {
                data:{
                    user_id:1,
                },
                item:'',
            }
        },
        methods: {
            async submit(){
                await axios.post('http://localhost:8080/api/book/create',this.data)
                    .then((res)=>{
                        this.item = res;
                        alert('登録が完了しました!');
                        this.$router.push({name: 'book.list'});
                    })
                    .catch((error) =>{
                        console.log(error);
                        alert('失敗です');
                    })
            }

        }
    }
</script>