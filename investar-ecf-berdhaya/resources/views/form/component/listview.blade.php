<a-config-provider>
    <template #renderEmpty>
        <div style="text-align: center; font-size: 12pt;border-bottom: thin solid lightgray;">
            <i class="las la-folder-open"></i>
        </div>
    </template>
    <a-list item-layout="horizontal" row-key="key" :data-source="{{ $form['model'] }}">
        <a-list-item slot="renderItem" slot-scope="it, idx">
            <a-list-item-meta
            >
                <span class="btn" slot="title" >{{ it.filename }}</span>
                <a-avatar
                    slot="avatar"
                    shape="square"
                    icon="file"
                    @click="itemClick(it)"
                    :src="getThumbnail(it)"
                />
                <div slot="description" >

                </div>
            </a-list-item-meta>
            <a slot="actions">
                <button class="btn btn-icon" @click="viewFile(it)">
                    <i style="color: red;" class="las la-eye"></i>
                </button>
            </a>
        </a-list-item>
    </a-list>

</a-config-provider>
