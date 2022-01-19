<template>
    <div class="body">
        <div class="test"></div>
        <div class="input">
            <div class="input-content">
                <div v-for="error in errors" :key="error.id">
                    <div class="error"><p>{{error}}</p></div>
                </div>
                <div class="input-content_header">
                    <h2 class="input-content_header-title">新規作成</h2>
                    <button class="search-btn" @click="openModal">本を検索する</button> 
                </div>
                <validation-observer tag="form" ref="obs" v-slot="ObserverProps" v-on:submit.prevent="submit">  
                    <div class="input-content_body">
                        <validation-provider v-slot="ProviderProps" rules="required|max:50">
                            <p>タイトル</p>
                            <input type="text" v-model="item.title" name="タイトル">
                            <div class="error">{{ProviderProps.errors[0]}}</div>
                        </validation-provider>
                        
                    </div>
                    <div class="input-content_body">
                        <validation-provider v-slot="ProviderProps" rules="required|max:30">
                            <p>著者</p>
                            <input type="text"  v-model="item.author" name="著者">
                            <div class="error">{{ProviderProps.errors[0]}}</div>
                        </validation-provider>
                    </div>
                    <div class="input-content_body">
                        <p class="input_rating-title">評価</p>
                        <star-rating v-model="rating" v-bind:increment="0.5"></star-rating>
                    </div>
                    <div class="input-content_body">
                        <validation-provider v-slot="ProviderProps" rules="required|max:500">
                            <p>感想</p>
                            <textarea v-model="item.report" name="感想"></textarea>
                            <div class="error">{{ProviderProps.errors[0]}}</div>
                        </validation-provider>
                    </div>
                    <button class="input-btn" type="submit" :disabled="ObserverProps.invalid">登録</button>
                </validation-observer>
            </div>
        </div>
        
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
                        this.$router.push({name: 'book.home'});
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

    input,textarea {
        width: 100%;
    }

    textarea {
        height: 200px;
    }

    .error {
        color: #666666;
    }
    
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

    .create {
        font-weight: bold;
        font-size: 2rem;
    }

    .input {
        margin: 3rem auto 0;
        width: 70%;
        background :#FFF6e6;
        box-shadow: 0 2px 3px rgba(0,0,0,.22);
        padding: 2.2rem 0.8rem 2.2rem 0.8rem;
    }

    .input:after {
        position: absolute;
        content: '';
        top: 185px;
        width: 30%;
        height: 35px;
        opacity: 0.3;
        margin: -35px auto 10px 35%;
        background: #db7093;
        transform: rotate(-2deg);
        left: 10px;
        right: 10px;
    }

    .input-content {
        width: 50%;
        margin: auto;
    }

    .input-content_header {
        display: flex;
        justify-content: space-between;
    }
    
    .input-content_header-title {
        font-size: 2rem;
        font-weight: bold;
        border-bottom: 2px solid #fff;
    }

    .input-content_body {
        margin-top : 1rem;
    }

    .search-btn {
        color: #fff;
        padding: 1rem;
        background-color: #eb6100;
        border-radius: 10px;
    }

    .search-btn:hover {
        background: #f56500;
    }

    .input-btn{
        padding: 0.5rem 1rem;
        background-color: #FFC7AF;
        border-radius: 10px;
    }

    :disabled {
        opacity:0.3;
        cursor: not-allowed;
    }
</style>