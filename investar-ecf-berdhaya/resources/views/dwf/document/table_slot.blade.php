<template v-else-if="props.column.field == 'origin'">
    <template v-if="_.has(props.row.footer, 'bizUnitCode')" >
        @{{ _.get(props.row.footer, 'bizUnitCode') }}
    </template>
    <template v-if="_.has(props.row.footer, 'bizUnitName')" >
        <hr>@{{ _.get(props.row.footer, 'bizUnitName') }}
    </template>
</template>

<template v-else-if="props.column.field == 'approvalAction'">
    <div class="row">
        <div class="col-4">
            <template v-if="showButtonApproval(props.row) == 2">
                <button  class="btn btn-icon" :id="'popcheckview-'+ props.row._id" >
                    <i class="las la-check-double"></i>
                </button>
                <b-popover
                    :target="'popcheckview-'+ props.row._id"
                    placement="top"
                    triggers="hover focus"
                    content="Approved"
                ></b-popover>
            </template>
            <template v-if="showButtonApproval(props.row) == 1">
                <button  class="btn btn-icon btn-primary"  :id="'popview-'+ props.row._id" href="#"
                        @click="printItem(props.row, props.row.formTemplate, 'xl'   )"
{{--                        v-if="props.row.ownerId != '{{ Auth::user()->_id }}'"--}}
                >
                    <i class="las la-signature"></i>
                </button>
                <b-popover
                    :target="'popview-'+ props.row._id"
                    placement="top"
                    triggers="hover focus"
                    content="Sign Doc"
                ></b-popover>
            </template>
        </div>
        <div  v-show="showButtonApproval(props.row) > 0" class="col-8 text-left ellipsis" style="padding-left: 0px;" >
            {{ Auth::user()->name }}
        </div>
    </div>
</template>
<template v-else-if="props.column.field == 'sendAction'">
    <div class="row">
        <div class="col-12 text-center">
            <button  :id="'popview-'+ props.row._id" href="#"
                    @click="openSendModal(props.row)"
                    v-if="props.row.docStatus == 'RELEASED'"
                     class="btn btn-primary"
            >
                <i style="font-size: 14pt;" class="lab la-telegram-plane"></i>
            </button>
            <b-popover
                :target="'popview-'+ props.row._id"
                placement="top"
                triggers="hover focus"
                content="Send Doc"
            ></b-popover>
        </div>
        <div class="col-12" v-html="props.row.sendStatus">
        </div>
    </div>
</template>
<template v-else-if="props.column.field == 'archiveAction'">
    <div class="row">
        <div class="col-12 text-center">
            <button  :id="'popview-'+ props.row._id" href="#"
                     @click="openArchiveModal(props.row)"
                     v-if="props.row.docStatus == 'RELEASED' && !( _.get(props.row, 'archiveStatus', 'UNARCHIVED' ) == 'ARCHIVED' ) && !_.isEmpty(archiveCategoryOptions) "
                     class="btn btn-info"
            >
                <i style="font-size: 14pt;" class="las la-box"></i>
            </button>
            <button href="#"
                     v-if="_.get(props.row, 'archiveStatus', 'UNARCHIVED' ) == 'ARCHIVED'"
                     class="btn"
            >
                <i style="font-size: 14pt;" class="las la-box"></i>
            </button>
            <b-popover
                :target="'popview-'+ props.row._id"
                placement="top"
                triggers="hover focus"
                content="Archive Doc"
            ></b-popover>
        </div>
        <div class="col-12" v-html="props.row.archiveStatus">
        </div>
    </div>
</template>
<template v-else-if="props.column.field == 'regDate'">
    @{{ props.row.regDate }}
    <hr>
    @{{ props.row.ownerName }}
    <hr>
    <span :class="props.row.docStatus" style="font-weight:800;" >
    @{{ props.row.docStatus }}
    </span>
</template>
<template v-else-if="props.column.field == 'docNo'">
    @{{ props.row.docNo }}
    <template v-if="keywords.keyword0 == 'status'" >
        <hr>@{{ titleCase( props.row.formTemplate ) }}
    </template>

</template>
<template v-else-if="props.column.field == 'recipient'">
    <a-config-provider>
        <template #renderEmpty>
            <div style="text-align: center">
                <i style="color: orange;" class="las la-exclamation-triangle"></i>
            </div>
        </template>
        <a-list item-layout="horizontal" row-key="key" :data-source="sortArray(props.row.recipient, [ 'obj.seq' ] )">
            <a-list-item slot="renderItem" slot-scope="it, idx">
                <a-list-item-meta
                    :description="it.obj.name"
                >
                </a-list-item-meta>
            </a-list-item>
        </a-list>
    </a-config-provider>
</template>
<template v-else-if="props.column.field == 'copy'">
    <a-config-provider>
        <template #renderEmpty>
            <div style="text-align: center">
                <i style="color: orange;" class="las la-exclamation-triangle"></i>
            </div>
        </template>
        <a-list item-layout="horizontal" row-key="key" :data-source="sortArray(props.row.copy, [ 'obj.seq' ] )">
            <a-list-item slot="renderItem" slot-scope="it, idx">
                <a-list-item-meta
                    :description="it.obj.name"
                >
                </a-list-item-meta>
            </a-list-item>
        </a-list>
    </a-config-provider>
</template>
<template v-else-if="props.column.field == 'signer'">
    <a-config-provider>
        <template #renderEmpty>
            <div style="text-align: center">
                <i style="color: orange;" class="las la-exclamation-triangle"></i>
            </div>
        </template>
        <a-list item-layout="horizontal" row-key="key" :data-source="sortArray(props.row.signer, [ 'obj.seq' ] )">
            <a-list-item slot="renderItem" slot-scope="it, idx">
                <a-list-item-meta
                    :description="it.obj.name"
                >
                </a-list-item-meta>
            </a-list-item>
        </a-list>
    </a-config-provider>
</template>
<template v-else-if="props.column.field == 'draftRecipient'">
    <a-config-provider>
        <template #renderEmpty>
            <div style="text-align: center">
                <i style="color: orange;" class="las la-exclamation-triangle"></i>
            </div>
        </template>
        <a-list item-layout="horizontal" row-key="key" :data-source="sortArray(props.row.draftRecipient, [ 'obj.seq' ] )">
            <a-list-item slot="renderItem" slot-scope="it, idx">
                <a-list-item-meta
                    :description="it.obj.name"
                >
                </a-list-item-meta>
            </a-list-item>
        </a-list>
    </a-config-provider>
</template>
<template v-else-if="props.column.field == 'attachments'">
    <a-config-provider>
        <template #renderEmpty>
            <div style="text-align: center">
                <i style="color: orange;" class="las la-exclamation-triangle"></i>
            </div>
        </template>
        <a-list item-layout="horizontal" row-key="key" :data-source="props.row.attachmentsObjects">
            <a-list-item slot="renderItem" slot-scope="it, idx">
                <a-list-item-meta
                >
                    <template slot="description">
                        <a style="font-size: 9pt;font-weight: bold;margin:0px;padding:0px;float:none;width:100%;" :href="it.url" target="_blank" >@{{ it.filename }}</a>
                        <p style="font-size: 9pt;font-weight: normal;" v-html="it.caption"></p>
                    </template>
                </a-list-item-meta>
            </a-list-item>
        </a-list>
    </a-config-provider>
</template>




