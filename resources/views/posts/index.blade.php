@extends('layouts.base')

@section('app', 'post-index')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-lg-10">
                <b-alert show variant="info" v-if="!posts.length" class="mt-5">Pas de post</b-alert>
                <b-table striped hover :items="posts" :fields="fields" caption-top v-else>
                    <template slot="table-caption">
                        <h2>Mes posts
                            <b-badge>@{{posts.length}}</b-badge>
                        </h2>
                        </h2>
                    </template>
                    <template slot="actions" slot-scope="data">
                        <b-button size="sm" variant="info"></b-button>
                    </template>
                    <template slot="actions" slot-scope="cell">
                        <!-- We use click.stop here to prevent a 'row-clicked' event from also happening -->
                        <b-btn size="sm" :href="cell.item.editUrl" variant="info"><i class="fas fa-edit"></i></b-btn>
                        <b-btn size="sm" @click.stop="remove(cell.item)" variant="danger"><i class="fas fa-trash"></i>
                        </b-btn>
                    </template>
                </b-table>
            </div>
            <div class="col-lg-2">
                <div class="card mt-5" no-header no-footer>
                    <b-btn href="{{ route('posts.create') }}" variant="success"><i class="fas fa-plus"></i> Nouveau
                    </b-btn>
                </div>
            </div>
        </div>
        <b-modal v-model="show" title="Suppression">
            <b-container fluid>
                <form :action="deleting.deleteUrl" method="post" class="delete-form-js">
                    @csrf
                    <input type="hidden" value="DELETE" name="_method">
                    Etes vous sur de vouloir supprimer <b>@{{ deleting.title }}</b>
                </form>
            </b-container>
            <div slot="modal-footer" class="w-100">
                <b-btn class="float-right" variant="danger" @click="confirmDelete" :disabled="isDeleting">
                    Supprimer <i class="fas fa-x fa-spinner fa-spin" v-if="isDeleting"></i>
                </b-btn>
                <b-btn @click="show=false" class="float-right" variant="default" role="button">
                    Annuler
                </b-btn>
            </div>

        </b-modal>
    </div>
@endsection

@push('scripts')
    <script>
        window.posts = @json($posts->map(function ($p) {
            $p->editUrl = route('posts.edit', ['id'
        =>
            $p->id
        ])
            ;
            $p->deleteUrl = route('posts.destroy', ['id'
        =>
            $p->id
        ])
            ;
            return $p;
        }));
    </script>
    <script src="{{mix('js/post-index.js')}}"></script>
@endpush