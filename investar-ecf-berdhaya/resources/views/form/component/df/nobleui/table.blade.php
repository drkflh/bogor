<div class="" style="border-radius: 1rem;">
    <div class="card-header p-2">
        <h5 class="mt-2 mb-2" v-html="{{ __($form['title']) }}"></h5>
    </div>
    <div class="card-body">
        <b-table-simple hover small responsive>
            <b-thead >
                <b-tr>
                    <b-th v-for="hval in {{ $form['header'] }}" v-html="hval" ></b-th>
                </b-tr>
            </b-thead>
            <b-tbody>
                <b-tr>
                    <b-td v-for="dval in {{ $form['data'] }}" v-html="dval" ></b-td>
                </b-tr>
            </b-tbody>
            <b-tfoot>
                <b-tr>
                    <b-td v-for="fval in {{ $form['footer'] }}" v-html="fval" ></b-td>
                </b-tr>
            </b-tfoot>
        </b-table-simple>
    </div>
</div>
