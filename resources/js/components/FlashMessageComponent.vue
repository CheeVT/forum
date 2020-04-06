<template>
    <div 
        class="alert alert--fixed" 
        :class="`alert-${type}`" 
        role="alert" 
        v-show="show" 
        v-text="body">
    </div>
</template>

<script>
    export default {
        props: ['message'],
        data() {
            return {
                body: this.message,
                type: 'success',
                show: false
            }
        },
        created() {
            if(this.message) {
                this.flash()
            }

            window.events.$on('flashMessage', data => this.flash(data))
        },
        methods: {
            flash(data) {
                if(data) {
                    this.body = data.message
                    this.type = data.type
                }
                this.show = true

                this.hide()
            },
            hide() {
                setTimeout(() => {
                    this.show = false
                }, 3000)
            }
        }
    }
</script>

<style>
    .alert--fixed {
        position: fixed;
        right: 25px;
        bottom: 25px;
    }
</style>
