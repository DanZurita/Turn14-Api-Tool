let _s = e => document.querySelector(e), a = _s("#a"), b = _s("#b"), h = 1, hh = 1, hhh = 1, final = {one: [], two: [], three: [], final: [], dump: []}, statuss = {one: "", two: "", three: ""}, preview_limit = 10;

_s("form").addEventListener("submit", (c) => {
    _reset();
    _s("#_g").innerHTML = "Generating...";
    c.preventDefault();
    h = 1;
    let text_a = a.value, text_b = b.value.toLowerCase();


    getToken().then(d => {
        if(d.access_token) {
            _s("#r").insertAdjacentHTML("beforeEnd", `<span><b>Token: </b>${d.access_token}</span>`);

            x(d.access_token, text_a, text_b);
            y(d.access_token, text_a, text_b);
            z(d.access_token, text_a, text_b);
        }
    })
});

async function getToken() {
    let g_a = await fetch("./a.php?type=token");
    let g_b = await g_a.json();
    return g_b;
}

const  getBrandData = async (token, id, page) => {
    let b_a = await fetch(`./a.php?type=brand_data&token=${token}&id=${id}&page=${page}`);
    let b_b = await b_a.json();
    console.log(b_b);
    return b_b;
}

const  getPricingData = async (token, id, page) => {
    let b_a = await fetch(`./a.php?type=brand_pricing_data&token=${token}&id=${id}&page=${page}`);
    let b_b = await b_a.json();
    return b_b;
}

const getItemData = async (token, id, page) => {
    let b_a = await fetch(`./a.php?type=brand_item_data&token=${token}&id=${id}&page=${page}`);
    let b_b = await b_a.json();
    return b_b;
};

const z = (i, j, k) => { //i - access token
    getBrandData(i, k, h).then(e => {
        //  console.log(e);
        if(e.errors) {
            _s("#r").insertAdjacentHTML("beforeEnd", `<span class="error">Error: ${e.errors.title}<span>`);
            return;
        }
        const g = e.data.slice().filter(f => {
            if (f && f.descriptions) {
              let de = f.descriptions;
              let df = de && de.find(ds => ds.type === "Product Description - Short");
              if (df && df.description) {
                return df.description.toLowerCase().indexOf(j) > -1;
              }
            }
            return false;
          });
          
          

        final.one.push(...g);
        // console.log(final);
        
        _s("#r").insertAdjacentHTML("beforeEnd", `<span><b>Brand Data Result Length: </b>${g.length}<b> from page </b>${h}</span>`);
        
        h++;
        
        if(e.meta.total_pages > 1 && h <= e.meta.total_pages) {
            setTimeout(()=>{z(i, j, k)}, 1000);
        }
        else statuss.one = "done";
        jo_in();
    })
}

const y = (i, j, k) => { //i - access token
    getPricingData(i, k, hh).then(e => {
        // console.log(e, "pricing information");

        if(e.errors) {
            _s("#r").insertAdjacentHTML("beforeEnd", `<span class="error">Error: ${e.errors.title}<span>`);
            return;
        }

        final.two.push(...e.data);
        
        _s("#r").insertAdjacentHTML("beforeEnd", `<span><b>Found: </b>${e.data.length}<b> items on pricing - page </b>${hh}</span>`);
        
        hh++;
        
        if(e.meta.total_pages > 1 && hh <= e.meta.total_pages) {
            setTimeout(()=>{y(i, j, k)}, 1000);
        }
        else statuss.two = "done";
        jo_in();
    })
}

const x = (i, j, k) => {
    getItemData(i, k, hhh).then(e => {
        console.log(e, "item data");
        if(e.errors) {
            _s("#r").insertAdjacentHTML("beforeEnd", `<span class="error">Error: ${e.errors.title}<span>`);
            return;
        }
        final.three.push(...e.data);

        _s("#r").insertAdjacentHTML("beforeEnd", `<span class="item_data"><b>Found: </b>${e.data.length}<b> results on item data - page </b>${hhh}</span>`);

        hhh++;

        if(e.meta.total_pages > 1 && hhh <= e.meta.total_pages) {
            setTimeout(()=>{x(i, j, k)}, 1000);
        }
        else statuss.three = "done";
        jo_in();

    })
}

function jo_in() {
    if(statuss.one !== "done" || statuss.two !== "done" || statuss.three !== "done") return;

    final.one.forEach(n => {
        let cc = final.two.find(o => o.id === n.id);
        let cd = final.three.find(o => o.id === n.id);
        const _obj = {};
        if(cc && cd) {
            let dee=n.descriptions;
            let dff=dee.find(ds=>ds.type==="Product Description - Short");
            _obj.id = n.id;
            _obj.image = n.files && n.files.length > 0 ? n.files[0].links[0].url : "";
            _obj.thumbnail = cd.attributes && cd.attributes.thumbnail ? cd.attributes.thumbnail : "";
            _obj.description = dff ? dff.description : dee[0].description;
            _obj.description_type = dff ? "Product Description - Short" : dee[0].type;
            _obj.pricing = cc.attributes.pricelists[0].price
            _obj.purchaseCost = cc.attributes.purchase_cost
            _obj.priceType = cc.attributes.pricelists[0].name;
            _obj.category = cd.attributes.category;
            _obj.brand = cd.attributes.brand;
            _obj.title = cd.attributes.product_name;
            _obj.weight = cd.attributes.dimensions[0].weight;
            _obj.height = cd.attributes.dimensions[0].height;
            _obj.length = cd.attributes.dimensions[0].length;
            _obj.width = cd.attributes.dimensions[0].width;
            final.final.push(_obj);
        }
        else {
            final.dump.push(n);
        }
    });

    _s("#r").insertAdjacentHTML("beforeEnd", `<span class="pricing"><b>Joined: </b>${final.final.length}<b> items with </b>${final.dump.length}<b> fails</b></span>`);
    
    let ht_ml = document.createElement("div");
    ht_ml.classList.add("flex");
    if(final.final.length === 0) {return;}
    ht_ml.innerHTML = `
    <span class="d">Download</span>
    <span class="p">Preview</span>
    `

    _s("#r").append(ht_ml);
    _s("#_g").innerHTML = "Generate";

    ht_ml.querySelector(".d").addEventListener("click", () => {
        JSONToCSVConvertor(final.final, "new file", true)
    });

    ht_ml.querySelector(".p").addEventListener("click", () => {
        _s("#t").innerHTML = `<div><br /><br /><center>Previewing ${preview_limit} of ${final.final.length}</center><br /></div>`;
       pre_view(final.final);
    });
    
    // down_load(final.final).then(console.log).catch(e => {
    //     _s("#e").innerHTML = `<span>Error: ${e}</span>`;
    // });

    

}

//deprecated
async function down_load(dt) {
    let d_a = await fetch("./a.php", {method: "POST", body: JSON.stringify({data: final.final})});
    let d_b = await d_a.text();
    console.log(d_b, "result");
    return d_b;
}


function pre_view(p_d = []) {
    let p_d_a = Object.keys(p_d[0]);
    console.log("check 1")
    if(p_d_a.length > 0) {
    console.log("check 2")

        let p_d_b = document.createElement("table");
        p_d_b.innerHTML = `
        <thead>
            <tr></tr>
        </thead>
        <tbody></tbody>
        `;
        let p_d_c = p_d_b.querySelector("thead tr");
        p_d_a.sort().forEach(a => {
    console.log("check 3")

            console.log(a);
            let p_d_d = document.createElement("th");
            p_d_d.innerHTML = a;
            p_d_c.append(p_d_d);
        });
        _s("#t").append(p_d_b);

        let p_d_e = p_d_b.querySelector("tbody");
        p_d.slice(0, preview_limit).forEach(d_item => {
            let p_d_f = document.createElement("tr");
            Object.keys(d_item).sort().forEach(d_item_b=>{let d_item_z = d_item[d_item_b];let d_item_c=document.createElement("td");d_item_c.innerHTML=d_item_z;p_d_f.append(d_item_c)});
            p_d_e.append(p_d_f);
        })
    }
}




// ------------------------------------reference-------------------------------------------------------
// https://stackoverflow.com/questions/8847766/how-to-convert-json-to-csv-format-and-store-in-a-variable
//------------------------------------ end reference ---------------------------------------------------

function JSONToCSVConvertor(JSONData, ReportTitle, ShowLabel) {
    var arrData = typeof JSONData != 'object' ? JSON.parse(JSONData) : JSONData;
    var CSV = '';
    if (ShowLabel) {
        var row = "";

        for (var index in arrData[0]) {
            row += index + ',';
        }
        row = row.slice(0, -1);
        CSV += row + '\r\n';
    }

    for (var i = 0; i < arrData.length; i++) {
        var row = "";
        for (var index in arrData[i]) {
            row += '"' + arrData[i][index] + '",';
        }
        row.slice(0, row.length - 1);
        CSV += row + '\r\n';
    }

    if (CSV == '') {
        alert("Invalid data");
        return;
    }

    var link = document.createElement("a");
    link.id = "lnkDwnldLnk";

    document.body.appendChild(link);

    var csv = CSV;
    blob = new Blob([csv], { type: 'text/csv' });
    var csvUrl = window.webkitURL.createObjectURL(blob);
    var filename =  (ReportTitle || 'UserExport') + '.csv';
    let a_a_a = document.createElement("a");
    a_a_a.setAttribute("href", csvUrl);
    a_a_a.setAttribute("download", filename);
    a_a_a.style.display = "none";
    document.body.appendChild(a_a_a);
    a_a_a.click();
    document.body.removeChild(a_a_a);
}

function _reset() {
    h = hh = hhh = 1;
    final = {
        one: [], two: [], three: [], final: [], dump: []
    };
    statuss = {one: "", two: "", three: ""};
    _s("#t").innerHTML = "";
    _s("#r").innerHTML = "";

}