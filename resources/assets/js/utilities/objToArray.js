// export this function refer by this name
export function objToValueTextArray(options) {
    const arr = []; // array to return

    //loop through all the objects in options and retrieve key and text
    for (let key in options) {
        arr.push({
            value: key,
            text: options[key]
        });
    }

    return arr;
}

