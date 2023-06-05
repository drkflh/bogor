<template>
    <div>
        <div class="row">
                <div class="col-1">
                     <p>Ketua Umum :</p>
                </div>
                <div class="col-2">
                    <input type="text"
                    v-model="orgTreeData.label"
                    class="form-control"
                    >
                </div>
                <div class="col-1">
                    <p>Top</p>
                </div>
        </div>
        <div class="row" v-for="(value, index) in orgTreeData.children">
            <div class="col-1">
                <p>Anggota{{index+1}}:</p>
            </div>
            <div class="col-2">
                <input type="text"
                v-model="value.label"
                class="form-control"
                >
            </div>
             <div class="col-1">
                    <p>Middle</p>
            </div>
        </div>
        <template v-for="value in orgTreeData.children">
            <div class="row" v-for="(values,index) in value.children">
                <div class="col-1">
                    <p>Grand Anggota{{index+1}}:</p>
                </div>
                <div class="col-2">
                   <input type="text"
                    v-model="values.label"
                    class="form-control">
                </div>
                 <div class="col-1">
                    <p>Bottom</p>
                </div>
            <div class="row" v-for="(valuess,index) in values.children">
                <div class="row">
                <div class="col-5">
                    Grand Grand Anggota
                </div>
               <div class="col-5">
                   <input type="text"
                    v-model="valuess.label"
                    class="form-control">
               </div>
                </div>
            </div>
            </div>
        </template>
    </div>
</template>

<script>
export default {
    name: "OrgTreeData",
    props:{
        orgTreeData: {
            type: [String, Object, Array],
            default: function(){
                return {};
            }
        }
    },
}
</script>
