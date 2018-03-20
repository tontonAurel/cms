import preloader from './mixins/preloader.js'
import bread from './mixins/bread.js'

const app = new Vue({
    el: '#post-history',
    mixins: [preloader, bread],
})


