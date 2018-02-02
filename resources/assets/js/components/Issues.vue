<template>
    <div v-cloak class="issues-container">
        <div class="loading-overlay" v-show="processing"></div>

        <div class="filters">
            <a href="#"
               title="Open Issues"
               class="filter"
               :class="filters.state == 'open' ? 'is-active' : ''"
               @click.prevent="state('open')"
               v-show="issues_count.open != null"
            >
                <i class="icon icon-exclamation-circle"></i>
                <span v-text="`${issues_count.open} Open`"></span>
            </a>

            <a href="#"
               title="Closed Issues"
               class="filter"
               :class="filters.state == 'closed' ? 'is-active' : ''"
               @click.prevent="state('closed')"
               v-show="issues_count.closed != null"
            >
                <i class="icon icon-check-circle"></i>
                <span v-text="`${issues_count.closed} Closed`"></span>
            </a>
        </div>

        <div class="list" ref="list">
            <div class="issue" v-for="issue in issues">
                <div class="state" :class="`is-${issue.state}`"></div>
                <div class="information">
                    <div class="name">
                        <a :href="issueUrl(issue)" v-text="issue.title"></a>
                        <span class="labels" v-if="issue.labels.length">
                            <span v-for="label in issue.labels"
                                  class="tag"
                                  :style="`background-color: #${label.color}`"
                                  v-text="label.name"
                            ></span>
                        </span>
                    </div>
                    <div class="notes">
                        #{{ issue.number }} opened {{ fromNow(issue.created_at) }}  by <a :href="issue.user.url" target="_blank" v-text="issue.user.login"></a>
                    </div>
                </div>
                <a :href="issueUrl(issue)" class="comments">
                    <i class="icon comments"></i>
                    <span v-text="issue.comments"></span>
                </a>
            </div>
        </div>

        <nav class="pagination is-rounded is-medium is-centered mt-1"
             role="navigation"
             aria-label="pagination"
             v-show="pagesCount > 1"
        >
            <paginate
                :page-count="pagesCount"
                container-class="pagination-list"
                page-link-class="pagination-link"
                prev-class="previous"
                next-class="next"
                prev-text="Previous"
                next-text="Next"
                :click-handler="changePage">
            </paginate>
        </nav>
    </div>
</template>

<script>
    import moment from 'moment';
    import Paginate from 'vuejs-paginate'

    export default {
        name: 'Issues',

        components: {
            Paginate
        },

        data() {
            return {
                processing: false,
                issues: [],
                issues_count: {
                    open: null,
                    closed: null
                },
                filters: {
                    page: 1,
                    per_page: 10,
                    state: 'closed'
                }
            }
        },

        watch: {
            filter_url() {
                this.filter();
            }
        },

        computed: {
            filter_url() {
                const filter_params = Object.entries(this.filters)
                    .map(([key, val]) => `${key}=${val}`)
                    .join('&');

                return `/issues/filter?${filter_params}`;
            },

            pagesCount() {
                return Math.ceil(this.issues_count[this.filters.state] / this.filters.per_page);
            }
        },

        mounted() {
            this.filter();
            this.count();
        },

        methods: {
            filter() {
                this.processing = true;
                axios.get(this.filter_url).then(({ data }) => {
                    this.issues = data.issues.items;
                    this.processing = false;
                }).catch((error) => {

                });
            },

            count() {
                axios.get('/issues/count').then(({ data }) => {
                    this.issues_count.open = data.open;
                    this.issues_count.closed = data.closed;
                }).catch((error) => {

                });
            },

            issueUrl(issue) {
                const fragments = issue.repository_url.split('/');

                return `/issues/${fragments[4]}/${fragments[5]}/${issue.number}`;
            },

            state(state) {
                this.filters.page = 1;
                this.filters.state = state;
            },

            fromNow(time) {
                return moment(time).fromNow();
            },

            changePage(page) {
                this.filters.page = page;
                this.$refs.list.scrollTop = 0;
            }
        }
    }
</script>