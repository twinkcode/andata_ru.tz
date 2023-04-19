<div id="app" class="bg-light p-3">
    <div class="container">
        <h4 class="text-center">Комментарии</h4>
        <p class="text-center"
           v-if="comments.length === 0"
        >отсутствуют</p>
        <div v-else class="card mb-3"
             v-for="comment in comments"
             :key="comment.id"
        >
            <div class="card-header d-flex justify-content-between">
                <small>{{ comment.created_at }}</small>
                <small>автор: <b>{{ comment.name }}</b></small>
            </div>
            <div class="card-body">
                <h6>{{ comment.title }}</h6>
                <blockquote class="blockquote mb-0">
                    <p>{{ comment.text }}</p>
                </blockquote>
            </div>
        </div>
    </div>

    <div class="container shadow-sm w-75 mx-auto bg-light px-5 py-3">
        <h4 class="text-center">Добавить комментарий</h4>
        <form @submit.prevent="addComment">
            <div class="mb-3">
                <label for="name" class="form-label">Имя пользователя</label>
                <input type="text" class="form-control"
                       id="name" placeholder="Имя"
                       v-model="newComment.name" required
                       pattern="[A-Za-zА-Яа-яЁё\s]+"
                >
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control"
                       id="email" placeholder="name@example.com"
                       v-model="newComment.email" required
                       pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$"
                >
            </div>
            <div class="mb-3">
                <label for="title" class="form-label">Заголовок комментария</label>
                <input type="text" class="form-control"
                       id="title" placeholder="Заголовок"
                       v-model="newComment.title" required
                >
            </div>
            <div class="mb-3">
                <label for="comment" class="form-label">Текст комментария</label>
                <textarea class="form-control"
                          id="comment" rows="3"
                          v-model="newComment.text"
                          required
                ></textarea>
            </div>
            <button class="btn btn-primary w-100" type="submit">Добавить</button>
        </form>
    </div>

</div>
<script type="module">
    import {createApp} from 'https://unpkg.com/vue@3/dist/vue.esm-browser.js'

    createApp({
        data() {
            return {
                loading: false,
                comments: [],
                newComment: {
                    name: '',
                    email: '',
                    title: '',
                    text: ''
                }
            }
        },
        async created() {
            await this.getComments()
        },
        methods: {
            async getComments() {
                try {
                    const response = await fetch('/comments')
                    if (response.ok) {
                        this.comments = await response.json()
                    } else {
                        console.error('Error fetching comments:', response.status)
                    }
                } catch (error) {
                    console.error('Error fetching comments:', error)
                }
            },
            async addComment() {
                try {
                    const response = await fetch('/comments', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify(this.newComment),
                    })
                    if (response.ok) {
                        let addedComment = await response.json()
                        if (addedComment) this.comments.push(addedComment);
                        this.newComment = {
                            name: '',
                            email: '',
                            title: '',
                            text: ''
                        }
                    } else {
                        console.error('Error adding comment:', response.status)
                    }
                } catch (error) {
                    console.error('Error adding comment:', error)
                }
            }
        }
    }).mount('#app')
</script>

