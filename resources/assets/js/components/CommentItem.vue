<template>
    <div>
        <div v-show="state === 'default'">
            <div class="flex justify-between mb-1">
                <p class="text-grey-darkest leading-normal text-lg">{{comment.body}}</p>
                <button v-if="editable" @click="state = 'editing'" class="ml-2 mt-1 mb-auto text-blue hover:text-blue-dark text-sm">Edit</button>
            </div>
            <div class="text-grey-dark leading-normal text-sm">
                <p>{{comment.author.name}} <span class="mx-1 text-xs">&bull;</span> {{ comment.created_at}}</p>
            </div>
        </div>
        <div v-show="state === 'editing'">
            <div class="mb-3">
                <h3 class="text-black text-xl">Update Comment</h3>
            </div>
            <textarea v-model="data.body"
                      placeholder="Update comment"
                      class="bg-grey-lighter rounded leading-normal resize-none w-full h-24 py-2 px-3">
            </textarea>
            <div class="flex flex-col md:flex-row items-center mt-2">
                <button class="border border-blue bg-blue text-white hover:bg-blue-dark py-2 px-4 rounded tracking-wide mb-2 md:mb-0 md:mr-1" @click="saveEdit">Update</button>
                <button class="border border-grey-darker text-grey-darker hover:bg-grey-dark hover:text-white py-2 px-4 rounded tracking-wide mb-2 md:mb-0 md:ml-1" @click="resetEdit">Cancel</button>
                <button class="text-red hover:bg-red hover:text-white py-2 px-4 rounded tracking-wide mb-2 md:mb-0 md:ml-auto" @click="deleteComment">Delete</button>
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
                return this.user.id === this.comment.author.id;
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