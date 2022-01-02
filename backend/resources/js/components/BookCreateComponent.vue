<template>
    <div>
        <label for="book_search">本情報検索</label>
        <input type="text" id="book_search" v-model="query">
        <form v-on:submit.prevent="submit">
            <div><p>評価</p>
                <star-rating v-model="rating" v-bind:increment="0.5"></star-rating>
            </div>
            <div>
                <lable for="title">タイトル</lable>
                <input type="text" id="title" v-model="item.title">
            </div>
            <div>
                <lable for="author">著者</lable>
                <input type="text" id="author" v-model="item.author">
            </div>
            <div>
                <lable for="report">感想</lable>
                <input type="text" id="report" v-model="item.report">
            </div>
            <button type="submit">登録</button>
            <p @click="getBook(query)">本情報取得ボタン</p>
            <p>{{rating}}</p>
        </form>
        <button @click="openModal">モーダルを開く</button>
        <div id="overlay" v-show="showContent">
            <div id="content">
                <p>これがモーダルウィンドウです</p>
                <p><button @click="closeModal">close</button></p>
            </div>
        </div>    
        <p @click="test">setData表示</p>
        <div v-if="st" >
            <div v-for="searchData in searchDatas" :key="searchData.id">
                <input type="radio" :value="searchData" v-model="setData">
                <p>{{searchData.volumeInfo.authors}}</p>
                <p>{{searchData.volumeInfo.title}}</p>
                <img v-bind:src="searchData.volumeInfo.imageLinks.smallThumbnail">
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props:['user'],
        data(){
            return {
                rating:0,
                item:{
                    user_id:this.user.id,
                },  
                searchDatas:'',
                showContent:false,
                query:'',
                st:true,
                setData:'',
        
            }
        },
        methods: {
            submit(){
                this.item.rating = this.rating;
                axios.post("http://localhost:8080/api/book",this.item)
                    .then((res)=>{
                        this.test = res;
                        alert('登録が完了しました!');
                        console.log(this.test);
                        this.$router.push({name: 'book.list'});
                    })
                    .catch((error) =>{
                        console.log(error);
                        console.log(this.item);
                        alert('失敗です');
                    })
            },

            getBook(query){
                axios.get("https://www.googleapis.com/books/v1/volumes?q=serch" + query)
                .then((res) => {
                    this.st = true;
                    this.searchDatas = res.data.items;
                    
                    console.log(this.searchDatas);
                })
                .catch((error) => {
                    console.log(error);
                    alert('失敗です')
                })
            },
            openModal(){
                this.showModal = true;
            },
            closeModal(){
                this.showModal = false;
            },
            test(){
                console.log(this.setData);
            }
        }
    }
</script>

<style>
    
    #overlay{
        z-index:1;
        position:fixed;
        top:0;
        left:0;
        width:100%;
        height:100%;
        background-color:rgba(0,0,0,0.5);
        display:flex;
        align-items:center;
        justify-content:center;
        
    }

    #content{
        z-index:2;
        width:50%;
        padding:1em;
        background:#fff;
    }
    
</style>