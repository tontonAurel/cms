import preloader from './mixins/preloader.js'

const app = new Vue({
    el: '#welcome',
    mixins: [preloader],
    data () {
        return {
            showCollapse: {}
        }
    }
})


