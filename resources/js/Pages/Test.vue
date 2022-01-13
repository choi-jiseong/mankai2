<template>
<div class="bg-blue-300 h-40 p-10"  @click="hideContextMenu()" @contextmenu="showContextMenu($event)">
    <h2 id="title-1" class="title">1</h2>
    <h2 id="title-2" class="title">2</h2>
    <ul v-show="false" id="div-context-menu" class="absolute list-unstyle bg-white border" >
        <li @click="addNewItem()" class="border hover:bg-red-500">add</li>
        <li @click="updateItem()" class="border hover:bg-red-500">update</li>
        <li @click="removeItem()" class="border hover:bg-red-500">delete</li>
    </ul>
</div>
</template>

<script>
export default {
    data() {
        return {
            cid: null,
            itemId : null,
        }
    },
    methods: {
        showContextMenu: function (e) {

           if ( e.target.className.startsWith("title") ) {
              e.preventDefault();
              var menu = document.getElementById("div-context-menu");
              menu.style.left = e.pageX + 'px'
              menu.style.top = e.pageY + 'px'
              menu.style.display = 'block'
              menu.cid = e.target.id.replace(/title-/,"")
              console.log ( "cid")
              console.log ( menu.cid )
              this.itemId = menu.cid;
           }else{
               this.hideContextMenu();
           }
        }
        , hideContextMenu: function () {
           document.getElementById("div-context-menu").style.display = "none"
        },
        addNewItem: function () {
           var msg = "UPDATE clicked for item-id : " + this.itemId
           console.log ( msg ) ;
        }
        , updateItem: function () {
           var msg = "UPDATE clicked for item-id : " + this.itemId
           console.log ( msg ) ;
        }
        , removeItem: function () {
           var msg = "REMOVE clicked for item-id : " + this.itemId
           console.log ( msg ) ;
        }
    },
}
</script>
