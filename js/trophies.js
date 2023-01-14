{
    let splide;
  const fillTrophies = (data) => {
    let dataArray = Array.from(data);
    let streak = parseInt(document.getElementById("streak").textContent);
    const $location = document.querySelector(".splide__list");
    dataArray.slice(0, streak);

    $location.innerHTML = dataArray
      .map(
        (element) =>
          `<li class="splide__slide">
                 <div class="splide__slide__container">
                     <img class="medal__image" src="assets/profile/${element["typeReward"]}/${element["asset"]}.png">
                </div>
            </li>`
      )
      .join("");
  };
  const detox = async () => {
    const url = "index.php?page=detoxApi";
    const response = await fetch(url);
    const data = await response.json();
    fillTrophies(data);
    // getProgress(data);
  };
  const init = async () => {
    await detox();
     splide = new Splide(".splide", {
        pagination: false,
        focus: 2,
        perPage: 2,
        trimSpace: true,
        focus: "center",
        start: 1,
        width: "60rem",
        gap: "3em",
        rewind: true,
      //"focus":"center", "start":"1", "width":"60rem","gap":"3rem;"
    }).mount();
  };
  init();
}
