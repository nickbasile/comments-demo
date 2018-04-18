<template>
    <div>
        <div v-show="state === 'default'">
            <div>
                <p>{{comment.body}}</p>
                <button v-if="editable" @click="state = 'editing'">Edit</button>
            </div>
            <div>
                <p>{{comment.author.name}} <span>&bull;</span>{{ comment.created_at}}</p>
            </div>
        </div>
        <div v-show="state === 'editing'">
            <div>
                <h3>Update Comment</h3>
            </div>
            <textarea v-model="data.body"
                      placeholder="Update comment"
                      class="border">
            </textarea>
            <div>
                <button @click="saveEdit">Update</button>
                <button @click="resetEdit">Cancel</button>
                <button @click="deleteComment">Delete</button>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            user: {
                required: true,
                type: Object,
            },
            comment: {
                required: true,
                type: Object,
            }
        },
        data: function() {
            return {
                state: 'default',
                data: {
                    body: this.comment.body,
                }
          }
        },
        computed: {
            editable() {
                return this.user.id === this.comment.id;
            },
        },
        methods: {
            resetEdit() {
                this.state = 'default';
                this.data.body = this.comment.body;
            },
            saveEdit() {
                this.state = 'default';

                this.$emit('comment-updated', {
                    'id': this.comment.id,
                    'body': this.data.body,
                });
            },
            deleteComment() {
                this.$emit('comment-deleted', {
                    'id': this.comment.id,
                });
            }
        }
    }
</script>