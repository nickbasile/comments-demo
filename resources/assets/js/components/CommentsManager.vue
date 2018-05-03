<template>
    <div class="max-w-3xl mx-auto">
        <div class="bg-white rounded shadow-sm p-8 mb-4">
            <div class="mb-4">
                <h2 class="text-black">Comments</h2>
            </div>
            <textarea v-model="data.body"
                      placeholder="Add a comment"
                      class="bg-grey-lighter rounded leading-normal resize-none w-full py-2 px-3"
                      :class="[state === 'editing' ? 'h-24' : 'h-10']"
                      @focus="startEditing">
            </textarea>
            <div v-show="state === 'editing'" class="mt-3">
                <button class="border border-blue bg-blue text-white hover:bg-blue-dark py-2 px-4 rounded tracking-wide mr-1" @click="saveComment">Save</button>
                <button class="border border-grey-darker text-grey-darker hover:bg-grey-dark hover:text-white py-2 px-4 rounded tracking-wide ml-1" @click="stopEditing">Cancel</button>
            </div>
        </div>
        <div class="bg-white rounded shadow-sm p-8">
            <comment v-for="(comment, index) in comments"
                     :key="comment.id"
                     :user="user"
                     :comment="comment"
                     :class="[index === comments.length - 1 ? '' : 'mb-6']"
                     @comment-updated="updateComment($event)"
                     @comment-deleted="deleteComment($event)">
            </comment>
        </div>
    </div>
</template>

<script>
    import comment from './CommentItem'
    export default {
        components: {
            comment
        },
        props: {
            user: {
                required: true,
                type: Object,
            }
        },
        data: function() {
            return {
                state: 'default',
                data: {
                    body: ''
                },
                comments: []
            }
        },
        created() {
            this.fetchComments();
        },
        methods: {
            startEditing() {
                this.state = 'editing';
            },
            stopEditing() {
                this.state = 'default';
                this.data.body = '';
            },
            fetchComments() {
                const t = this;

                axios.get('/comments')
                    .then(({data}) => {
                        t.comments = data;
                    })
            },
            updateComment($event) {
                const t = this;

                axios.put(`/comments/${$event.id}`, $event)
                    .then(({data}) => {
                        t.comments[t.commentIndex($event.id)].body = data.body;
                    })
            },
            deleteComment($event) {
                const t = this;

                axios.delete(`/comments/${$event.id}`, $event)
                    .then(() => {
                        t.comments.splice(t.commentIndex($event.id), 1);
                    })
            },
            saveComment() {
                const t = this;

                axios.post('/comments', t.data)
                    .then(({data}) => {
                        t.comments.unshift(data);

                        t.stopEditing();
                    })
            },
            commentIndex(commentId) {
                return this.comments.findIndex((element) => {
                    return element.id === commentId;
                });
            }
        }
    }
</script>