<template>
    <div>
        <h2>Articles</h2>
        <form @submit.prevent="addArticle" class="mb-3">
            <div class="form-group">
                <input type="text" class="form-control" placeholder="Title" v-model="article.title">
            </div>
            <div class="form-group">
                <textarea type="text" class="form-control" v-model="article.body"></textarea>
            </div>
            <div>
                <button class="btn btn-outline-primary">Save</button>
            </div>
        </form>
        <nav aria-label="Page navigation">
            <ul class="pagination">
                <li v-bind:class="[{disabled: !pagination.prev_page_url}]"
                    class="page-item"><a class="page-link" href="#"
                    @click="fetchArticles(pagination.prev_page_url)"
                    >Previous</a>
                </li>
                <li class="page-item disabled"><a class="page-link text-dark" href="#">
                    Page {{pagination.current_page}} of {{pagination.last_page}}
                </a></li>
                <li v-bind:class="[{disabled: !pagination.next_page_url}]"
                    class="page-item"><a class="page-link" href="#"
                    @click="fetchArticles(pagination.next_page_url)"
                    >Next</a></li>
            </ul>
        </nav>
        <div v-for="article in articles">
            <div class="card border-info mb-3">
                <div class="card-header text-center">{{article.title}}</div>
                <div class="card-body">{{article.body}}</div>
                <div class="card-footer">
                    <button @click="deleteArticle(article.id)" class="btn btn-danger btn sm">Delete</button>
                    <button @click="editArticle(article)"class="btn btn-info btn sm" >Edit</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data(){
            return{
                articles:[],
                article:{
                    id: '',
                    title: '',
                    body: '',
                },
                article_id:'',
                pagination:{},
                edit: false
            }
        },

        created(){
            this.fetchArticles();
        },

        methods: {
            fetchArticles(page_url){
                let vm = this;
                page_url = page_url || '/api/articles';
                fetch(page_url)
                    .then(res =>res.json())
                    .then(res => {
                        this.articles = res.data;
                        vm.makePagination(res.meta, res.links);
                    })
                    .catch(err => console.log(err));
            },

            makePagination(meta, links){
                let pagination = {
                    current_page: meta.current_page,
                    last_page: meta.last_page,
                    next_page_url: links.next,
                    prev_page_url: links.prev
                }
                this.pagination = pagination;
            },

            deleteArticle(id){
                if(confirm('Are you Sure?')){
                    fetch(`api/article/${id}`,{
                        method: 'delete'
                    })
                        .then(res => res.json())
                        .then(data =>{
                            alert('Article Removed');
                            this.fetchArticles();
                        })
                        .catch(err => console.log(err));
                }
            },

            addArticle(){
                if(this.edit === false){
                    fetch('api/article', {
                        method: 'post',
                        body: JSON.stringify(this.article),
                        headers: {
                            'content-type': 'application/json'
                        }
                    })
                        .then(res => res.json())
                        .then(data => {
                            this.article.title ='';
                            this.article.body = '';
                            alert('Article Added');
                            this.fetchArticles();
                        })
                        .catch(err => console.log(err));
                }else{
                    fetch('api/article', {
                        method: 'put',
                        body: JSON.stringify(this.article),
                        headers: {
                            'content-type': 'application/json'
                        }
                    })
                        .then(res => res.json())
                        .then(data => {
                            this.article.title ='';
                            this.article.body = '';
                            alert('Article Updated');
                            this.fetchArticles();
                        })
                        .catch(err => console.log(err));
                }
            },
            editArticle(article){
                this.edit = true;
                this.article.id = article.id;
                this.article.article_id = article.id;
                this.article.title = article.title;
                this.article.body = article.body;

            }
        }

    }
</script>

<style scoped>

</style>
