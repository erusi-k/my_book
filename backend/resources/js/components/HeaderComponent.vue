<template>
    <div>
        <ul>
            <li>ホーム</li>
            <li>mybookについて</li>
            <li>mybook</li>
            <li><router-link v-bind:to="{name: 'book.create'}">新規作成</router-link></li>
            <li>ログアウト</li>
        </ul>
        <router-link v-bind:to ="{name: 'book.list'}">
            <p>一覧表示</p>
        </router-link>
    </div>
</template>

<script>

export default {
    
}
</script>