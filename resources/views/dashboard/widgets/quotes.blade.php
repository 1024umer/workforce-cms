
<div class="col-md-6" id="quotesAppDiv">
    <div class="modal fade" id="quoteModal" tabindex="-1" aria-labelledby="quoteModal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="d-flex align-items-center postheader">
                        <div class="flex-shrink-0"><img class="img-avatar" src="https://randomuser.me/api/portraits/men/85.jpg" alt="admin"></div>
                        <div class="flex-grow-1 ms-3">
                            <h4>@{{quote?.user?.name}}</h4>
                            <span class="ocu"><i class="fas fa-clock"></i> @{{quote.created_at_formatted}}</span>
                            <!-- <div v-if="quote.user_id=={{auth()->user()->id}}" class="toogle">
                                <a href="javascript:void(0);" type="button" class="dropdown-toggle" data-bs-toggle="dropdown"><i class="fas fa-ellipsis" aria-hidden="true"></i></a>
                                <ul class="dropdown-menu">
                                    <a href="javascript:void(0);" type="button" class="dropdown-toggle" data-bs-toggle="dropdown"></a>
                                    <li><a href="javascript:void(0);" type="button" class="dropdown-toggle" data-bs-toggle="dropdown"></a>
                                    <a class="dropdown-item" href="javascript:void(0)"><button type="button" class="del">Delete</button></a></li>
                                </ul>
                            </div> -->
                        </div>
                    </div>
                </div>
                <div class="modal-body">
                    <div class="postBox">
                        <div v-html="quote.post">
                        </div>
                        <img v-if="quote.image" class="img-fluid" :src="quote.image.full_url" alt="">
                        <div class="clearfix"></div>
                        <section v-if="quote?.comments?.length>0" class="comment-section">
                            <div v-for="comment in quote.comments" class="comment">
                                <div class="d-flex">
                                    <div class="flex-shrink-0">
                                        <img :src="comment?.user?.image_url" :alt="comment?.user?.name" class="img-avatar">
                                    </div>
                                    <div class="flex-grow-1 ms-3"><a :href="'/users/'+comment.user_id">
                                        <span class="name">@{{comment?.user?.name}}</span></a>
                                        <div class="dip">
                                            <p style="white-space: pre-line;">@{{comment.comment}}</p>
                                        </div><span class="date">@{{comment.created_at_formatted}}</span>
                                    </div>
                                </div>
                            </div>
                        </section>
                        <hr>
                        <div class="d-flex media align-items-center">
                            <img class="img-avatar" src="{{auth()->user()->image_url}}" alt="profile picture">
                            <div class="flex-shrink-0"></div>
                            <div class="flex-grow-1 ms-3">
                                <textarea v-on:keyup="submitComment" :data-id="quote.id" :id="'quoteinput'+quote.id" class="form-control"></textarea>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <button type="button" @click="submitCommentBtn(quote)">Comment</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="postArea">
        <h3>Today Quotes</h3>
        <div class="postBox" v-for="quote in quotes" :key="quote.id">
            <div class="d-flex align-items-center postheader">
                <div class="flex-shrink-0">
                    <img class="img-avatar" :src="quote?.user?.image_url" :alt="quote?.user?.name">
                </div>
                <div class="flex-grow-1 ms-3">
                    <h4>@{{quote?.user?.name}}</h4>
                    <span class="ocu"><i class="fas fa-clock"></i> @{{quote.created_at_formatted}}</span>
                    <!-- <div v-if="quote.user_id=={{auth()->user()->id}}" class="toogle"> <a href="javascript:void(0);" type="button" class="dropdown-toggle" data-bs-toggle="dropdown"><i class="fas fa-ellipsis"></i>
                            <ul class="dropdown-menu">
                                <li>
                                    <a class="dropdown-item" href="javascript:void(0)">
                                        <button type="button" class="del">Delete</button>
                                    </a>
                                </li>
                            </ul>
                        </a>
                    </div> -->
                </div>
            </div>
            <div v-html="quote.post"></div>
            <img v-if="quote.image" class="img-fluid" :src="quote.image.full_url" alt="" />
            <div class="clearfix"></div>
            <div class="dici"><a href="javascript:void(0);" type="button" class="linkBtn" @click="showPost(quote)">
                    @{{quote.comments.length}} <i class="fa fa-comments"></i></a>
            </div>
        </div>
    </div>
    <div class="birthdayCalendar table-responsive">

    </div>
    @include('dashboard.widgets.gcalendar')
</div>
  @push('js')
  <script>
      $(document).ready(function() {
          axios.get('{{route('dashboard.birthdays')}}').then(e => e.data).then(e => {
              $('.birthdayCalendar').html(e)
          })
      })

      function getMonthBirthday(m, y) {
          axios.get('{{route('dashboard.birthdays')}}?year=' + y + '&month=' + m).then(e => e.data).then(e => {
              $('.birthdayCalendar').html(e)
          })
      }
  </script>
  <script>
      const quotesListApp = createApp({
          data() {
              return {
                  quotes: [],
                  quote: {},
              }
          },
          async mounted() {
              const {
                  quotes
              } = await axios.get('/dashboard/today-quotes').then(e => e.data)
              this.quotes = quotes
          },
          methods: {
            showPost(quote){
                this.quote = quote
                $('#quoteModal').modal('show')
            },
            async submitComment(e) {
                if (e.keyCode == 13 && e.shiftKey === true) {
                    const formData = new FormData();
                    const quote_id = e.target.dataset.id
                    formData.append('comment', e.target.value)
                    e.preventDefault();
                    await axios.post('/quotes/' + quote_id + '/comments', formData).then(e => e.data).then(e => {
                        const _indexQuote = (this.quotes.findIndex(e => e.id == quote_id))
                        this.quotes[_indexQuote].comments = e.comments
                        document.getElementById('quoteinput' + quote_id).value = ''
                    })
                    return false
                }
            },
            async submitCommentBtn(quote){
                const comment = document.getElementById('quoteinput'+quote.id).value
                const formData = new FormData();
                const quote_id = quote.id
                formData.append('comment', comment)
                await axios.post('/quotes/' + quote_id + '/comments', formData).then(e => e.data).then(e => {
                    const _indexQuote = (this.quotes.findIndex(e => e.id == quote_id))
                    this.quotes[_indexQuote].comments = e.comments
                    document.getElementById('quoteinput' + quote_id).value = ''
                })
                return false
            }
          }
      }).mount('#quotesAppDiv')
  </script>
  @endpush