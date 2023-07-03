const showInput = (id, placeholder) => {
    const input = document.querySelector(`input[data-key=${id}]`);
    input.setAttribute("placeholder", placeholder)
    const classLists = input.classList;
    classLists.toggle("display-none");
}
const changeSection = (id, e) => {
    let children = document.getElementById("all-sections").children;
    children = [...children];
    children.forEach((child, index) => {
        child.classList.add("display-none");
        const classNames = child.classList[0] + "-opt";
        document.getElementById(classNames).classList.remove("active");
    })
    // console.log(classes);
    document.getElementById(id).classList.remove("display-none");
    document.getElementById(id + "-opt").classList.add("active");
    // document.
}