import preloader from './mixins/preloader.js'
import form from './mixins/form.js'
import bread from './mixins/bread.js'
import moment from 'moment'

const app = new Vue({
    el: '#post-create',
    mixins: [preloader, form, bread],
    data () {
        return {
            post: {
                'date': window.old.date ||moment().format('YYYY-MM-DD'),
                'title': window.old.title || '',
                'description': window.old.description || ''
            },
        }
    },
})


