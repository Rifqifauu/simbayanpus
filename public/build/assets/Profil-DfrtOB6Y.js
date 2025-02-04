import{f,g as S,h as c,c as g,b as o,t as k,d as h,w as D,a as s,M as V,E as x,l as M,o as b}from"./app-EjIw6IA4.js";import{A as _}from"./AppLayout-DPeSRmQm.js";import{E}from"./ErrorModal-DAURxi9Q.js";import{S as P}from"./SuccessModal-DmRL_KCq.js";import{_ as q}from"./_plugin-vue_export-helper-DlAUqK2U.js";const C=x({props:{modelValue:String,label:String,type:{type:String,default:"text"},placeholder:String,required:Boolean},emits:["update:modelValue"],template:`
      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">
          {{ label }}
          <span v-if="required" class="text-red-500">*</span>
        </label>
        <input
          :type="type"
          :value="modelValue"
          @input="$emit('update:modelValue', $event.target.value)"
          :placeholder="placeholder"
          :required="required"
          class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-red-500 focus:border-red-500"
        >
      </div>
    `}),F=x({props:{modelValue:String,label:String,placeholder:String,rows:{type:[Number,String],default:3}},emits:["update:modelValue"],template:`
      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">
          {{ label }}
        </label>
        <textarea
          :value="modelValue"
          @input="$emit('update:modelValue', $event.target.value)"
          :placeholder="placeholder"
          :rows="rows"
          class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-red-500 focus:border-red-500"
        ></textarea>
      </div>
    `}),j=x({props:{modelValue:String,label:String,options:Array,required:Boolean},emits:["update:modelValue"],template:`
      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">
          {{ label }}
          <span v-if="required" class="text-red-500">*</span>
        </label>
        <select
          :value="modelValue"
          @input="$emit('update:modelValue', $event.target.value)"
          :required="required"
          class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-red-500 focus:border-red-500"
        >
          <option value="">Pilih {{ label }}</option>
          <option 
            v-for="option in options" 
            :key="option.value"
            :value="option.value"
          >
            {{ option.label }}
          </option>
        </select>
      </div>
    `}),B={name:"EditProfile",layout:_,components:{FormInput:C,FormTextarea:F,FormSelect:j,ErrorModal:E,SuccessModal:P},props:{user:{type:Object,required:!0},userDetail:{type:Object,required:!0},title:String,success:String,error:String},mounted(){document.title=this.title},setup(i){console.log("Props di setup:",i);const e=f({...i.userDetail}),m=f(""),a=f(!1),u=f(!1),v=f(null),n=t=>{const r=t.target.files[0];r&&(v.value=URL.createObjectURL(r),e.value.foto=r)},w=S(()=>i.userDetail!==null&&i.userDetail!==void 0);return{showSuccessModal:a,formData:e,preview:v,handleImageChange:n,handleSubmit:async()=>{try{const t=new FormData;Object.entries(e.value).forEach(([p,d])=>{d!=null&&(p==="foto"&&d instanceof File,t.append(p,d))}),i.userDetail&&t.append("_method","PUT"),t.forEach((p,d)=>{console.log("Isi Form",`Key: ${d}, Value: ${p}`)});const r=i.userDetail?"/profile/edit":"/profile/store",l=await M.post(r,t);console.log(l.data),l.status===200&&(a.value=!0,setTimeout(()=>{a.value=!1},2e3))}catch(t){if(t.response&&t.response.data.errors)console.error("Error updating profile:",t),m.value=t.response.data.errors,u.value=!0,setTimeout(()=>{u.value=!1},2e3);else{console.error("An unexpected error occurred:",t.response.data.messages);for(let r in t.response.data.messages)t.response.data.messages.hasOwnProperty(r)&&(console.log(`Error in ${r}:`,t.response.data.messages[r][0]),m.value=t.response.data.messages[r][0],u.value=!0,setTimeout(()=>{u.value=!1},2e3))}}},isEdit:w,showErrorModal:u,errorMessage:m}}},I={class:"min-h-screen bg-gray-50 py-8 px-4"},U={class:"max-w-4xl mx-auto bg-white shadow-xl rounded-lg overflow-hidden"},N={class:"bg-red-600 text-white flex justify-between items-center p-4 rounded-2xl"},T={class:"text-lg font-semibold"},K={class:"md:w-2/5 p-6 bg-gray-50"},L={class:"text-center mb-6"},z={class:"w-40 h-50 mx-auto rounded overflow-hidden border-4 border-white shadow-lg relative group"},A=["src","alt"],H={key:1,class:"w-full h-full p-8 bg-gray-200 flex items-center justify-center"},O={class:"absolute inset-0 bg-black bg-opacity-50 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity"},G={class:"cursor-pointer bg-white text-gray-800 px-4 py-2 rounded-lg hover:bg-gray-100"},R={class:"mt-4 text-left space-y-4"},J={class:"space-y-4"},Q=["value"],W={class:"space-y-4 mt-4"},X=["href"],Y=["href"],Z={class:"md:w-3/5 p-6"},$={class:"space-y-4"};function ee(i,e,m,a,u,v){const n=c("FormInput"),w=c("ErrorModal"),y=c("SuccessModal"),t=c("FormTextarea"),r=c("FormSelect");return b(),g("div",I,[o("div",U,[o("div",N,[o("h2",T,k(a.isEdit?"Edit Profile":"Create Profile"),1),o("button",{onClick:e[0]||(e[0]=(...l)=>a.handleSubmit&&a.handleSubmit(...l)),class:"flex items-center bg-white text-red-600 px-4 py-2 rounded-lg hover:bg-gray-100 transition-colors"},[e[12]||(e[12]=o("svg",{xmlns:"http://www.w3.org/2000/svg",class:"w-5 h-5 mr-2",fill:"none",viewBox:"0 0 24 24",stroke:"currentColor"},[o("path",{"stroke-linecap":"round","stroke-linejoin":"round","stroke-width":"2",d:"M5 13l4 4L19 7"})],-1)),h(" "+k(a.isEdit?"Simpan":"Buat"),1)])]),o("form",{onSubmit:e[11]||(e[11]=D((...l)=>a.handleSubmit&&a.handleSubmit(...l),["prevent"])),class:"md:flex"},[o("aside",K,[o("div",L,[o("div",z,[a.preview||a.formData.foto?(b(),g("img",{key:0,src:a.preview||`/storage/${a.formData.foto}`,alt:a.formData.name,class:"w-full h-full object-cover"},null,8,A)):(b(),g("div",H,e[13]||(e[13]=[o("svg",{xmlns:"http://www.w3.org/2000/svg",class:"w-full h-full text-gray-400",fill:"none",viewBox:"0 0 24 24",stroke:"currentColor"},[o("path",{"stroke-linecap":"round","stroke-linejoin":"round","stroke-width":"2",d:"M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z"})],-1)]))),o("div",O,[o("label",G,[o("input",{type:"file",class:"hidden",accept:"image/*",onChange:e[1]||(e[1]=(...l)=>a.handleImageChange&&a.handleImageChange(...l))},null,32),e[14]||(e[14]=h(" Ganti Foto "))])])]),o("div",R,[s(n,{modelValue:a.formData.panggilan,"onUpdate:modelValue":e[2]||(e[2]=l=>a.formData.panggilan=l),label:"Nama Panggilan",placeholder:"Masukkan nama panggilan"},null,8,["modelValue"])])]),o("div",J,[e[15]||(e[15]=o("h2",{class:"text-xl font-semibold text-red-600"},"Kontak",-1)),s(n,{modelValue:a.formData.nomor_hp,"onUpdate:modelValue":e[3]||(e[3]=l=>a.formData.nomor_hp=l),type:"tel",label:"Nomor HP",placeholder:"Masukkan nomor HP"},null,8,["modelValue"]),s(n,{modelValue:a.formData.medsos,"onUpdate:modelValue":e[4]||(e[4]=l=>a.formData.medsos=l),label:"Media Sosial",placeholder:"Link media sosial"},null,8,["modelValue"])]),e[18]||(e[18]=o("h2",{class:"text-md mt-4 font-semibold text-red-600"},"Status Pendaftaran",-1)),o("input",{value:a.formData.status_pendaftaran,disabled:""},null,8,Q),o("div",W,[a.formData.status_pendaftaran=="diterima"?(b(),g("a",{key:0,href:"download/sk_diterima/"+m.user.id,class:"inline-flex text-sm items-center gap-2 px-2 py-2 bg-blue-600 text-white font-semibold rounded-lg shadow-md transition-all duration-300 hover:bg-blue-700 hover:-translate-y-1 active:translate-y-0"},e[16]||(e[16]=[o("svg",{class:"w-5 h-5",fill:"currentColor",viewBox:"0 0 24 24"},[o("path",{d:"M12 16l4-5h-3V4h-2v7H8l4 5zm-6 2h12v2H6v-2z"})],-1),h(" Download Surat Keterangan Diterima ")]),8,X)):V("",!0),a.formData.status_pendaftaran=="selesai"?(b(),g("a",{key:1,href:"download/sk_selesai/"+m.user.id,class:"inline-flex items-center gap-2 px-4 py-2 bg-blue-600 text-white font-semibold rounded-lg shadow-md transition-all duration-300 hover:bg-blue-700 hover:-translate-y-1 active:translate-y-0"},e[17]||(e[17]=[o("svg",{class:"w-3 h-3",fill:"currentColor",viewBox:"0 0 24 24"},[o("path",{d:"M12 16l4-5h-3V4h-2v7H8l4 5zm-6 2h12v2H6v-2z"})],-1),h(" Download Surat Keterangan Selesai Magang ")]),8,Y)):V("",!0)])]),s(w,{show:a.showErrorModal,message:a.errorMessage,title:"Gagal Mengubah Profil"},null,8,["show","message"]),s(y,{show:a.showSuccessModal,title:"Berhasil Mengubah Profil"},null,8,["show"]),o("main",Z,[e[19]||(e[19]=o("h2",{class:"text-2xl font-semibold text-red-600 mb-4"},"Biodata",-1)),o("div",$,[s(n,{modelValue:a.formData.nim,"onUpdate:modelValue":e[5]||(e[5]=l=>a.formData.nim=l),label:"NIM",placeholder:"Masukkan NIM",required:""},null,8,["modelValue"]),s(n,{modelValue:a.formData.nik,"onUpdate:modelValue":e[6]||(e[6]=l=>a.formData.nik=l),label:"NIK",placeholder:"Masukkan NIK",required:""},null,8,["modelValue"]),s(n,{modelValue:a.formData.program_studi,"onUpdate:modelValue":e[7]||(e[7]=l=>a.formData.program_studi=l),label:"Program Studi",placeholder:"Masukkan program studi",required:""},null,8,["modelValue"]),s(n,{modelValue:a.formData.institusi,"onUpdate:modelValue":e[8]||(e[8]=l=>a.formData.institusi=l),label:"Institusi",placeholder:"Masukkan institusi",required:""},null,8,["modelValue"]),s(t,{modelValue:a.formData.alamat,"onUpdate:modelValue":e[9]||(e[9]=l=>a.formData.alamat=l),label:"Alamat",placeholder:"Masukkan alamat lengkap",rows:"3"},null,8,["modelValue"]),s(r,{modelValue:a.formData.jenis_kelamin,"onUpdate:modelValue":e[10]||(e[10]=l=>a.formData.jenis_kelamin=l),label:"Jenis Kelamin",options:[{value:"Laki-laki",label:"Laki-laki"},{value:"Perempuan",label:"Perempuan"}],required:""},null,8,["modelValue"])])])],32)])])}const se=q(B,[["render",ee]]);export{se as default};
