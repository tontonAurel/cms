import preloader from './mixins/preloader.js'
import form from './mixins/form.js'
import moment from 'moment'

const app = new Vue({
    el: '#post-create',
    mixins: [preloader, form],
    data () {
        return {
            bread: window.bread,
            post: {
                'date': window.old.date ||moment().format('YYYY-MM-DD'),
                'title': window.old.title || '',
                'description': window.old.description || ''
            },
        }
    },
})


