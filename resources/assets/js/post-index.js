import preloader from './mixins/preloader.js'
import moment from 'moment'

const app = new Vue({
    el: '#post-index',
    mixins: [preloader],
    data () {
        return  {
            deleting: false,
            show: false,
            isDeleting: false,
            fields: [
                'title',
                {
                    // A regular column with custom formatter
                    key: 'date',
                    formatter: (value) => { return moment(value).format('DD/MM/YYYY') }
                },
                'actions'
            ],
            posts: window.posts
        }
    },
    methods: {
        remove (item) {
            this.deleting = item
            this.show = true
        },
        confirmDelete () {
            this.isDeleting = true
            this.$el.querySelector('.delete-form-js').submit()
        }
    }
})


