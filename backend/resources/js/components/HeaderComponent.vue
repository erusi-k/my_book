<template>
    <div class="body">
        <div v-show="resp">
            <div class="header-resp" ></div>
            <div class="header-btn" @click="active=!active">
                <span class="line line-top" :class="{'rotate-top' :active}"></span>
                <span class="line line-middle" :class="{'rotate-middle' :active}"></span>
                <span class="line line-bottom" :class="{'rotate-bottom' :active}"></span>
            </div> 
            <div>
                <router-link v-bind:to="{name: 'book.home'}">
                    <h1 class="header-title_resp">mybook</h1>
                </router-link>
            </div>
        </div>        
            <transition name="header-menu">
                <div class="header-menu" v-show="active">
                    <ul class="header-menu_content">
                        <li class="heaer-menu_list" @click="active=!active">
                            <router-link class="header-inner" v-bind:to="{name: 'book.home'}">
                                <img src="/images/home.png" alt="ホームアイコン">
                                <p>ホーム</p>
                            </router-link>
                        </li >
                        <li class="heaer-menu_list" @click="active=!active">
                            <router-link class="header-inner" v-bind:to="{name: 'book.create'}">
                                <img src="/images/new.png" alt="新規アイコン">
                                <p>新規作成</p>
                            </router-link>    
                        </li>
                        <li class="heaer-menu_list" @click="active=!active">
                            <router-link class="header-inner" v-bind:to="{name: 'book.mylist'}" >
                                <img src="/images/mylist.jpg" alt="マイリストアイコン">
                                <p>マイリスト</p>
                            </router-link>    
                        </li>
                        <li class="heaer-menu_list" @click="active=!active">
                            <router-link class="header-inner" v-bind:to="{name: 'book.other'}">
                                <img src="/images/otherlist.jpg" alt="投稿一覧アイコン">
                                <p>みんなの投稿一覧</p>
                            </router-link>    
                        </li>
                    </ul>
                </div>
            </transition>
        
        <div v-show="!resp" class="header">
            <router-link v-bind:to="{name: 'book.home'}">
                <h1 class="header-title">mybook</h1>
            </router-link>
            <ul class="header-list">
                <li class="header-list_content">
                    <router-link v-bind:to="{name: 'book.home'}">
                        <p>ホーム</p>
                        <img src="/images/home.png" alt="ホームアイコン">
                    </router-link>
                    
                </li>
                <li class="header-list_content">
                    <router-link v-bind:to="{name: 'book.create'}">
                        <p>新規作成</p>
                        <img src="/images/new.png" alt="新規アイコン">
                    </router-link>
                </li>
                <li class="header-list_content">
                    <router-link v-bind:to="{name: 'book.mylist'}">
                        <p>マイリスト</p>
                        <img src="/images/mylist.jpg" alt="マイリストアイコン">
                    </router-link>
                </li>
                <li class="header-list_content">
                    <router-link v-bind:to="{name: 'book.other'}">
                        <p>みんなの投稿一覧</p>
                        <img src="/images/otherlist.jpg" alt="投稿一覧アイコン">
                    </router-link>
                </li>
            </ul>
        </div>
    </div>
</template>

<script>

export default ({
    data(){
        return {
            active: false,
            resp: false,
        }
    },
    methods: {

    //画面検知    
        handleResize(){
            if(window.innerWidth <= 1024){
                this.resp = true;
            }else {
                this.resp = false;
            }
        },
    },
    created(){
        window.addEventListener('resize',this.handleResize);
        this.handleResize();
    }
})
</script>

<style scoped>

.body {
    width: 100%;
    font-family: 'Hannotate SC', 'Arial','Hiragino Kaku Gothic ProN','ヒラギノ角ゴ ProN W3','メイリオ', Meiryo,sans-serif;
    background-color: #FFDBC9;
}

/* スマホタイトル css  */
.header-resp {
    position: fixed; 
    top: 0;
    background: #FFDBC9;
    width: 100%;
    height: 70px;
    z-index: 50;

}

.header-title_resp {
    position: fixed; 
    top: 0;
    left: 25%;
    align-items: center;
    font-size: 3rem;
    color: #FF5F17;
    font-weight:bold;
    z-index: 50;
}


/* ハンバーガーメニューcss */
.header-btn {
    position: fixed;
    top: 10px;
    left: 0;
    width: 70px;
    height: 70px;
    cursor: pointer;
    z-index: 60;
}


.line {
    position: absolute;
    top: 0;
    left: 20px;
    width: 45px;
    height: 2px;
    background: #000;
    text-align: center;
}

.line-top {
    top: 16px;
    transition: 0.4s ease;
}

.line-middle {
    top: 26px;
    transition: 0.4s ease;
}

.line-bottom {
    top: 36px;
    transition: 0.4s ease;
}

.rotate-top {
    transform: translateY(10px) rotate(-45deg);
    transition: 0.4s ease;
}

.rotate-middle {
    transition: 0.4s ease;
    opacity: 0;
}

.rotate-bottom {
    transform: translateY(-10px) rotate(45deg);
    transition: 0.4s ease;
}

.header-menu-enter-active, .header-menu-leave-active {
    opacity: 0.4;
}

.header-menu-enter, .header-menu-leave-to {
    opacity: 0;
}

.header-menu-leave, .header-menu-enter-to {
    opacity: 1;
}

.header-menu {
    background: #FFC7AF;
    z-index: 20;
    padding: 2rem 1rem;
    position: fixed;
    width: 100Vh;
    height: 80rem;
    top: 0;
    left: 0;
}

.header-inner {
    display: flex;
}

.header-inner p {
    margin-left: 1rem
}

.header-inner p:first-letter {
    color: #FF5F17;
    font-size: 2rem
}


.header-menu_content {
    padding: 0;
    padding-top: 40px;
}

.heaer-menu_list {
    padding: 35px;
    list-style: none;
    line-height: 1;
    font-size: 1.5rem;
}



img {
    width: 2.2rem;
    height: 2.2rem;
    display: inline-block;
    
}

.header {
    width: 80%;
    margin: auto;
    padding: 1rem 0 1rem;
    display: flex;
    justify-content: space-between;
    
}

.header-title {
    align-items: center;
    font-size: 3.5rem;
    color: #FF5F17;
    border-bottom: 2.5px solid #FFF;
    font-weight:bold;
}


.header-list {
    display: flex;
    border-bottom: 2.5px solid #FFF;
    align-items: center;
}

.header-list_content:last-child {
    border-right: 2px dotted #FAEBD7;
}

.header-list_content {
    padding-left: 2rem;
    padding-right: 2rem;
    text-align: center;
    border-left: 2px dotted #FAEBD7;
}

.header-list_content p {
    margin-bottom: 0.5rem;
}

.header-list_content:hover {
    background-image: url('/images/select.png');
    background-size: 70px;
    background-repeat: no-repeat;
    background-position: 50% 50%;
}

@media screen and (max-width: 1024px) {
    .header-title_resp {
        position: fixed; 
        top: 0;
        left: 40%;
    }
}

@media screen and (max-width: 480px) {
    .header-title_resp {
        position: fixed; 
        top: 0;
        left: 25%;
        font-size: 2rem;
    }
}


</style>