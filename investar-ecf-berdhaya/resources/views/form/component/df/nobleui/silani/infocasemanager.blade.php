<div class="card card-list shadow-sm" style="border-radius: 1rem; height: 465px">
    <div class="card-body">
      <h4 v-html="{{ $form['label'] }}"></h4>
      {{-- info utama --}}
      <div class="d-flex justify-content-between align-items-center">
        <div class="d-flex mt-3">
          <i class="las la-user la-4x mr-3"></i>
          <h1 v-html="{{ $form['total_user'] }}"></h1>
        </div>
        <a class="btn btn-primary py-2 px-4" :href="{{ $form['btn_view'] }}">Lihat Detail</a>
      </div>

      {{-- info detail --}}
      <h4 class="mt-3"><b>Info Detail</b></h4>
      <table class="table table-hover table-responsive overflow-auto" style="height: 220px">
          <thead>
              <tr>
                  <th v-for="(item, index) in {{ $form['th_table'] }}" :key="index"
                      
                  >
                      <b v-html="item" @if(isset($form['th_class']))
                      :class="{{ $form['th_class'] }}[index]"
                  @endif></b>
                  </th>
              </tr>
          </thead>
          <tbody>
              <tr v-for="(item, index) in {{ $form['td_table']}}" :key="index"
              >
                  <td style="font-size: 14px;"
                      @if(isset($form['th_class']))
                          :class="{{ $form['th_class'] }}[0]"
                      @endif
                  >
                      <p v-html="index+1"></p>
                  </td>
                  <td style="font-size: 14px;" 
                      @if(isset($form['th_class']))
                          :class="( index > 0)?{{ $form['th_class'] }}[index]:''"
                      @endif
                  >
                    <img style="width: 45px;height: 45px;" :src="item.caseData.avatar"
                    onerror="this.onerror=null;this.src='{{ url( env('DEFAULT_AVATAR', 'images/coffee.png' ) ) }}';" class="rounded-circle">
                  </td>
                  <td style="font-size: 14px;" 
                      @if(isset($form['th_class']))
                          :class="( index > 0)?{{ $form['th_class'] }}[index]:''"
                      @endif
                  >
                    <p class="ellipsis" v-if="item.caseData.name" v-html="item.caseData.name"></p>
                    <p v-else>-</p>
                  </td>
                  <td style="font-size: 14px;" 
                      @if(isset($form['th_class']))
                          :class="( index > 0)?{{ $form['th_class'] }}[index]:''"
                      @endif
                  >
                    <p class="text-center" v-if="item.countLansia" v-html="item.countLansia"></p>
                    <p class="text-center" v-else>0</p>
                  </td>
                  <td style="font-size: 14px;" 
                      @if(isset($form['th_class']))
                          :class="( index > 0)?{{ $form['th_class'] }}[index]:''"
                      @endif
                  >
                    <p class="text-center" v-if="item.countReqToday" v-html="item.countReqToday"></p>
                    <p class="text-center" v-else>0</p>
                  </td>
                  <td style="font-size: 14px;" 
                      @if(isset($form['th_class']))
                          :class="( index > 0)?{{ $form['th_class'] }}[index]:''"
                      @endif
                  >
                    <p class="text-center" v-if="item.countReqMonth" v-html="item.countReqMonth"></p>
                    <p class="text-center" v-else>0</p>
                  </td>
                  <td style="font-size: 14px;" 
                      @if(isset($form['th_class']))
                          :class="( index > 0)?{{ $form['th_class'] }}[index]:''"
                      @endif
                  >
                    <p class="text-center" v-if="item.countAvgMonth" v-html="item.countAvgMonth"></p>
                    <p class="text-center" v-else>0</p>
                  </td>
              </tr>
          </tbody>
      </table>
      
    </div> 
</div>
