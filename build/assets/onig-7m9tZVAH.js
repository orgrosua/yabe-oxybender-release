const o=async(a={},r)=>{let i;if(r.startsWith("data:")){const t=r.replace(/^data:.*?base64,/,"");let e;if(typeof Buffer=="function"&&typeof Buffer.from=="function")e=Buffer.from(t,"base64");else if(typeof atob=="function"){const n=atob(t);e=new Uint8Array(n.length);for(let s=0;s<n.length;s++)e[s]=n.charCodeAt(s)}else throw new Error("Failed to decode base64-encoded data URL, Buffer and atob are not supported");i=await WebAssembly.instantiate(e,a)}else{const t=await fetch(r),e=t.headers.get("Content-Type")||"";if("instantiateStreaming"in WebAssembly&&e.startsWith("application/wasm"))i=await WebAssembly.instantiateStreaming(t,a);else{const n=await t.arrayBuffer();i=await WebAssembly.instantiate(n,a)}}return i.instance},f=a=>o(a,""+new URL("onig-Du5pRr7Y.wasm?init",import.meta.url).href);export{f as default};