const formToJson = (selector) => {
    const ary = $(selector).serializeArray();
    const obj = {};
    for (let a = 0; a < ary.length; a++) obj[ary[a].name] = ary[a].value;
    return obj;
}