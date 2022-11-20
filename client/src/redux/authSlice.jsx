import { createSlice, createAsyncThunk } from "@reduxjs/toolkit";
const initialState = {
    msg: "",
    user: "",
    token: "",
    loading: false,
    error: "",
};

export const signUpUser = createAsyncThunk('signupuser', async (body) => {
    const res = await fetch('http://localhost:8080/api/register', {
        method: "post",
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(body)
    });
    //console.table( 'body', body );
    //const aaa = await res.json();
    //return aaa;
    return await res.json();
});

//const headers = {
//    'Content-Type': 'application/json',
//    'Access-Control-Allow-Origin': '*'
//};

const headers = {};

export const signInUser = createAsyncThunk('signinuser', async (body) => {
    const res = await fetch('http://localhost:8080/api/login', {
        method: "post",
        headers: headers,
        body: JSON.stringify(body)
    });
    //const aaa = await res.json();
    //console.table('aaa', aaa);
    //return aaa;
    return await res.json();
});

const authSlice = createSlice({
    name: "user",
    initialState,
    reducers: {
        addToken: (state, action) => {
            state.token = localStorage.getItem('token');
        },
        addUser: (state, action) => {
            state.user = localStorage.getItem('user');
        },
        logout: (state, action) => {
            state.token = null;
            localStorage.clear();
        }
    },
    extraReducers: (builder) => {
        builder
            /* LOGIN */
            .addCase(signInUser.pending, (state,action) => { state.loading = true; } )
            .addCase(signInUser.fulfilled, (state,{payload:{error,msg,token,user}}) => {
                state.loading = false;
                if(error){
                    state.error = error;
                }else{
                    state.msg = msg;
                    state.token = token;
                    state.user = user;

                    localStorage.setItem('msg', msg);
                    localStorage.setItem('token', token);
                    localStorage.setItem('user', JSON.stringify(user));

                    console.log( JSON.parse(localStorage.getItem('user')) );

                }
            } )
            .addCase(signInUser.rejected, (state,action) => { state.loading = true; } )
            /* REGISTER */
            .addCase(signUpUser.pending, (state,action) => { state.loading = true; } )
            .addCase(signUpUser.fulfilled, (state,{payload:{error,msg,token,user}}) => {
                state.loading = false;
                if(error){
                    state.error = error;
                }else{
                    state.msg = msg;
                    state.token = token;
                    state.user = user;

                    localStorage.setItem('msg', msg);
                    localStorage.setItem('token', token);
                    localStorage.setItem('user', JSON.stringify(user));

                    console.log( JSON.parse(localStorage.getItem('user')) );

                }
            } )
            .addCase(signUpUser.rejected, (state,action) => { state.loading = true; } )
            .addDefaultCase( (state, action) => {} )
    }
});

export const { addToken, addUser, logout } = authSlice.actions;
export default authSlice.reducer;