<template>
    <div class="body">
        <div class="header">
            <h1 class="header-title">mybook</h1>
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
                    <p>マイリスト</p>
                    <img src="/images/mylist.jpg" alt="マイリストアイコン">
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

export default {
    
}
</script>

<style scoped>

.body {
    font-family: 'Hannotate SC','Hiragino Kaku Gothic ProN','ヒラギノ角ゴ ProN W3','メイリオ', Meiryo,sans-serif;
    background-color: #FFDBC9;
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
    transform: scale(1.3,1.3);
}



</style>