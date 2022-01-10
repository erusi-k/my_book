<template>
    <div>
        <div v-for="error in errors" :key="error.id">
            <div class="error">{{error}}</div>
        </div>
        <label for="book_search">本情報検索</label>
            <validation-observer tag="form" ref="obs" v-slot="ObserverProps" v-on:submit.prevent="submit">
                <div>
                    <p>評価</p>
                    <star-rating v-model="rating" v-bind:increment="0.5"></star-rating>
                </div>
                <div>
                    <validation-provider v-slot="ProviderProps" rules="required|max:50">
                        <lable for="title">タイトル</lable>
                        <input type="text" id="title" v-model="item.title" name="タイトル">
                        <div class="error">{{ProviderProps.errors[0]}}</div>
                    </validation-provider>
                    
                </div>
                <div>
                    <validation-provider v-slot="ProviderProps" rules="required|max:30">
                        <lable for="author">著者</lable>
                        <input type="text" id="author" v-model="item.author" name="著者">
                        <div class="error">{{ProviderProps.errors[0]}}</div>
                    </validation-provider>
                </div>
                <div>
                    <validation-provider v-slot="ProviderProps" rules="required|max:500">
                        <lable for="report">感想</lable>
                        <input type="text" id="report" v-model="item.report" name="感想">
                        <div class="error">{{ProviderProps.errors[0]}}</div>
                    </validation-provider>
                </div>
                <button type="submit" :disabled="ObserverProps.invalid">登録</button>
            </validation-observer>
        
        
        <div id="overlay" v-show="showContent">
            <div id="content">
                <input type="text" id="book_search" v-model="query">
                <p @click="getBook(query)">本情報取得ボタン</p>
                <p v-if="bookEmpty">検索結果がありません</p>
                <div v-for="searchData in searchDatas" :key="searchData.id">
                    <input type="radio" :value="searchData" v-model="selectData">
                    <p>{{searchData.volumeInfo.authors}}</p>
                    <p>{{searchData.volumeInfo.title}}</p>
                    <img v-bind:src="searchData.volumeInfo.imageLinks&&searchData.volumeInfo.imageLinks.smallThumbnail" >
                </div>
                <p @click="setData">データセット</p>
                <p><button @click="closeModal">close</button></p>
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
                bookEmpty:false,
                selectData:{},
                errors:{},
        
            }
        },
        methods: {
            submit(){
                this.item.rating = this.rating;
                axios.post("http://localhost:8080/api/book",this.item)
                    .then((res)=>{
                        this.test = res;
                        Swal.fire('登録が完了しました!');
                        console.log(this.item);
                        this.$router.push({name: 'book.list'});
                    })
                    .catch((error) =>{
                        this.errors = error.response.data.errors;
                        console.log(this.errors);
                        console.log(error);
                    })
            },

            getBook(query){
                axios.get(`https://www.googleapis.com/books/v1/volumes?q=serch+${query}&maxResults=15`)
                .then((res) => {
                    if(res.data.items != null){
                        this.searchDatas = res.data.items;
                        this.bookEmpty = false;
                    }else{
                        this.searchDatas = '';
                        this.bookEmpty = true;
                    }
                    
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
            },
        },
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