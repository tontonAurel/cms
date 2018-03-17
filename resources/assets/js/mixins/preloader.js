export default {
    mounted() {
        document.querySelector('#main-loader').remove()
        document.querySelector('body').classList.remove("h-100")
        document.querySelector('html').classList.remove("h-100")
        this.$el.classList.remove('d-none')
    }
}