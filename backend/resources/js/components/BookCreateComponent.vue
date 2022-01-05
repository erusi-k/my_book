<template>
    <div>
        <label for="book_search">本情報検索</label>
        
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
            <p>{{rating}}</p>
        </form>
        <div id="overlay" v-show="showContent">
            <div id="content">
                <input type="text" id="book_search" v-model="query">
                <p @click="getBook(query)">本情報取得ボタン</p>
                <div v-if="st" >
                    <div v-for="searchData in searchDatas" :key="searchData.id">
                        <input type="radio" :value="searchData" v-model="selectData">
                        <p>{{searchData.volumeInfo.authors}}</p>
                        <p>{{searchData.volumeInfo.title}}</p>
                        <img v-bind:src="searchData.volumeInfo.imageLinks.smallThumbnail">
                    </div>
                    <p @click="setData">データセット</p>
                    <p><button @click="closeModal">close</button></p>
                </div>
            </div>
        </div>
        <button @click="openModal">本を検索する</button>    
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
                    title:'',
                    author:'',
                    imge:'',
                },  
                searchDatas:'',
                showContent:false,
                query:'',
                st:true,
                selectData:'',
        
            }
        },
        methods: {
            submit(){
                this.item.rating = this.rating;
                axios.post("http://localhost:8080/api/book",this.item)
                    .then((res)=>{
                        this.test = res;
                        alert('登録が完了しました!');
                        console.log(this.item);
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
                this.showContent = true;
                console.log('動いている');
            },
            closeModal(){
                this.showContent = false;
            },
            setData(){
                this.item.title = this.selectData.volumeInfo.title;
                this.item.author = this.selectData.volumeInfo.authors[0];
                this.item.imge = this.selectData.volumeInfo.imageLinks.smallThumbnail;
                console.log(this.item);
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
        height:100vh;
        padding:1em;
        background:#fff;
        overflow: auto;
        overflow: scroll;
    }
    
</style>