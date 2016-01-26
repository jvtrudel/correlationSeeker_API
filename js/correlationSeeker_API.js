// implémentation à partir de fred seul.
function correlationSeeker_API(){

   this.numReg=new RegExp('^\\d+$');
   this.root=[];
   this.currentOptions=[];
   this.nextOptions={};

   this.hasKey=function(){
      if(this.key==undefined){
         return false;
      }else{
         return true;
      }
   };

   // lecture de l'API_key
   this.config=function(config){
      $.ajax({url:config,
         context:this,
         async:false,
         dataType:"json",
         success:function(data){
         this.server=data.server}
      ,fail:function(){
         console.log("Erreur: correlationSeekerAPI.config(), ajax get json");
      }})
      this.init();
      return this;
   };


   this.reset=function(){
       this.currentOptions=this.root;
       this.getNextOptions();
       return this;
   };

   this.select=function(id){
      if(this.numReg.test(id)){
         this.currentOptions=this.nextOptions[id];
         this.getNextOptions();
         return [true,this.currentOptions];
      }else{
            for (var i=0;i<this.currentOptions.length;i++){
            console.log(this.currentOptions[i]);
            if(this.currentOptions[i].id==id){
               tmp=this.currentOptions[i];
            }
             }
      tmp=this.currentOptions;
   //   console.log(id);
         this.getSerie(id);
         return [false,this.currentOptions,tmp];
      }
   };

   this.init=function(){
      res="";
   //   console.log(this.server+"?method=getChildCategories&id=0");
      $.when(this.config).done(function(){$.ajax({
         url:this.server+"?method=getChildCategories&id=0",
         contentType:"application/json",
         dataType:"json",
         async:false,
         success:function(data){
            res=data},
         fail:function(){
            console.log("Erreur: correlationSeekerAPI.init(), getChildCategories");
         }
      })}.bind(this));
      this.root=res;
      this.currentOptions=res;
      this.getNextOptions();
      return res;
   };


   this.getNextOptions=function(){
      this.nextOptions={};
      for(var categ in this.currentOptions){
         var id=this.currentOptions[categ].id;
         $.ajax({
            url:this.server+"?method=getChildCategories&id="+id,
            contentType:"application/json",
            dataType:"json",
            context:{"this":this,"id":id},
            success:function(data){
               if(data.length!=0){
                  this.this.nextOptions[this.id]=data;
               }else{
                  $.ajax({
                     url:this.this.server+"?method=getSeriesInfo&id="+this.id,
                     context:this,
                     dataType:"json",
                     contentType:"application/json",
                     success:function(data2){
                        //console.log(data2);
                        this.this.nextOptions[this.id]=data2;
                     },
                     fail:function(){
                        console.log("Erreur: correlationSeekerAPI.getNextOptions(), getSeriesInfo")
                     }
                  })
               }
            }
         });
      }
   };

this.getSerie=function(id){
   //console.log(id);
   $.ajax({
         url:this.server+"?method=getSerie&id="+id,
         context:this,
         dataType:"json",
         contentType:"application/json",
         async:false,
         success:function(data){
            this.currentOptions=data
         },
         fail:function(){
            console.log("Erreur: correlationSeekerAPI.getNextOptions(), getSerie")
         }

   })
};


return this
};
