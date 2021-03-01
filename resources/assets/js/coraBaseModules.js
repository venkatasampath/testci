//required libraries
import axios from 'axios';


// export this function refer by this name
function changeObjectToArray(options){
  const arrayToReturn = []; //array to return

    //loop through all the objects in options and retrieve key and text
    for (let key in options) {
        arrayToReturn.push({
            value: key,
            text: options[key]
        });
    }

    return arrayToReturn;
}


// ToDo remove the api bearer token once the authentication part resolves
//this function needs url to be passed
function apiGetCall(url){
    var responseData = [];
    var errored = false;

    // uncomment for debugging
    console.log(url);
    axios
        .request({
            url: url,
            method: 'GET',
            headers:{
                'Content-Type' : 'application/json',
                'Authorization' : 'Bearer zijaNN5p3v250jSlA4XN9BpeRawTYXcT93kGgkptQMxGLamGwdDFyEGD3P5M'
            }
        })
        .then(response=>{
            // uncomment for debugging
            // console.log(response.data.data)
            response.data.data.map(item => responseData.push(item));
        })
        .catch(error => {
            console.log(error)
            errored = true;
            return errored;
        })
    return responseData
}


function apiGetCallAxios(url){
    // uncomment for debugging
    // console.log(url);
    return axios
        .request({
            url: url,
            method: 'GET',
            headers:{
                'Content-Type' : 'application/json',
                'Authorization' : 'Bearer zijaNN5p3v250jSlA4XN9BpeRawTYXcT93kGgkptQMxGLamGwdDFyEGD3P5M'
            }
        })
}

// ToDo remove the api bearer token once the authentication part resolves
// this function is used to post data to the backend
// Url of the api
// Type such as pair, articulations, etc
// data you need to pass e.g listIds = []
function apiPostCall(url, type, data){
    var errored = false;
    var succeed = false;

    // uncomment for debugging
    // console.log(data);

    axios.request({
            url: url,
            method: 'PUT',
            headers:{
                'Content-Type' : 'application/json',
                'Authorization' : 'Bearer zijaNN5p3v250jSlA4XN9BpeRawTYXcT93kGgkptQMxGLamGwdDFyEGD3P5M'
            },
            data:{
                type: type,
                listIds: data.map(data => data.toString())
            }
        })
        .then(response=>{
            succeed = true;

            // uncomment for debugging
            // console.log(response);
        })
        .catch(error => {
            // uncomment for debugging
            // console.log(error.response);
            errored = true
        })
}

// ToDo zones api call will be removed once the zones changes to listIds
// ToDo remove the api bearer token once the authentication part resolves
// this function is used to post the data, you need pass url of the API, type: e.g zones, articulation,etc, and data to post
function apiPostCallZones(url, type, data){
    var errored = false;
    var succeed = false;

    axios
        .request({
            url: url,
            method: 'PUT',
            headers:{
                'Content-Type' : 'application/json',
                'Authorization' : 'Bearer zijaNN5p3v250jSlA4XN9BpeRawTYXcT93kGgkptQMxGLamGwdDFyEGD3P5M'
            },
            data:{
                type: type,
                listIds: data
            }
        })
        .then(response=>{
            succeed = true;

            // uncomment for debugging
            // console.log(response);
        })
        .catch(error => {
            // uncomment for debugging
            // console.log(error.response);
            errored = true
        })
    }

export const bus = new Vue();

export {changeObjectToArray, apiGetCall, apiPostCall, apiPostCallZones, apiGetCallAxios}