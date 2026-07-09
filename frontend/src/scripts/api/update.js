export async function updateUser(apiUrl, id,{name,age,email}) {
    const response = await fetch(`${apiUrl}? id=${id}`, {
        method: 'PUT',
        headers : { 'Content-type' : 'application/json'},
        body : JSON.stringify({name, age: Number(age), email}),
    });

    const data = await response.json();

    if(!response.ok){
        throw new Error(data.error || 'tfailed to update user');
    }
    return data;
}

//patch - parceial

export async function patchUser(apiUrl,id,fields) {
    if (fields.age != undefined){
        fields.age = Number(fields.age);
    }

    const response = await fetch (`${apiUrl}?id=${id}`, {
        method: 'PATCH',
        headers : { 'Content-type' : 'application/json'},
        body : JSON.stringify(fields)
    });

    const data = await response.json();

    if(!response.ok){
        throw new Error (data.error || 'failed to patch user');
    }
    return data;
}