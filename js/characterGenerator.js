{
    let  head,body;
    let headSelector, bodySelector;

    const makePreview=()=>{
        // head.Attributes.add("src", `../assets/generator/bodies/${bodySelector.value}`);
        body["src"]= `./assets/generator/bodies/${bodySelector.value}.png`;
        // head["src"]= `./assets/generator/heads/goat${headSelector.value}.png`;
        // body.style.backgroundImage = `url("./assets/generator/bodies/${bodySelector.value}.png")`;
        head.style.backgroundImage = `url("./assets/generator/heads/goat${headSelector.value}.png")`;
        let color= document.querySelector(`#colorSelector`).value;
        let overlay= document.getElementById('overlay');
        //let overlay = document.querySelector('.preview__body');
        overlay.style.backgroundColor =`${color}`;
        //body.style.setProperty("--overlay", `${color}`)
    }

    const init = ()=>{
        const form= document.querySelector('.characterForm');
        form.addEventListener('change',makePreview);
        headSelector= document.getElementById("characterHead");
        
        bodySelector= document.getElementById('characterBody');
        // head= document.querySelector('.preview__head--image');
        // body= document.querySelector('.preview__body--image');
        head= document.querySelector('.preview__head');
        body= document.querySelector('.preview__body--image');
        console.log(headSelector.value);
      
    }
    init();
}