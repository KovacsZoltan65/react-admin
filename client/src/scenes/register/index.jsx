/*
https://www.youtube.com/watch?v=X3qyxo_UTR4&t=792s&ab_channel=DaveGray
https://github.com/gitdagray/react_login_form

import api from '../../api';
const LOGIN_URL = '/auth';

*/
//import { useState, useEffect } from 'react';
import { Box, Button, TextField, useMediaQuery } from "@mui/material";
import Header from "../../components/Header";
//import { tokens } from "../../theme";
import { Formik } from "formik";
import * as yup from "yup";
import { useDispatch } from "react-redux";
import { signInUser } from "../../redux/authSlice";

const Login = () => {

    const dispatch = useDispatch();
    
    const isNonMobile = useMediaQuery("(min-width:600px)");

    const initialValues = {
        name: "",
        email: "",
        password: "",
        confirm_password: ""
    };

    const handleFormSubmit = (values) => {
        console.log(values);
        dispatch(signInUser(values));
    };

    return (
        <Box m="20px">
            <Header title="REGISTER" subtitle="Register your account" />
    
            <Formik onSubmit={handleFormSubmit}
                    initialValues={initialValues}
                    validationSchema={checkoutSchema}>
            {({
              values,
              errors,
              touched,
              handleBlur,
              handleChange,
              handleSubmit,
            }) => (
                <form onSubmit={handleSubmit}>
                    <Box display="grid"
                         gap="30px"
                         gridTemplateColumns="repeat(4, minmax(0, 1fr))"
                         sx={{"& > div": { gridColumn: isNonMobile ? undefined : "span 4" },}}>
                        {/* NAME */}
                        <TextField fullWidth
                                   variant="filled"
                                   type="text"
                                   label="Name"
                                   onBlur={handleBlur}
                                   onChange={handleChange}
                                   value={values.name}
                                   name="name"
                                   error={!!touched.name && !!errors.name}
                                   helperText={touched.name && errors.name}
                                   sx={{ gridColumn: "span 4" }}/>
                        {/* EMAIL */}
                        <TextField fullWidth
                                   variant="filled"
                                   type="text"
                                   label="Email"
                                   onBlur={handleBlur}
                                   onChange={handleChange}
                                   value={values.email}
                                   name="email"
                                   error={!!touched.email && !!errors.email}
                                   helperText={touched.email && errors.email}
                                   sx={{ gridColumn: "span 4" }}/>
                        {/* PASSWORD */}
                        <TextField fullWidth
                                   variant="filled"
                                   type="text"
                                   label="Password"
                                   onBlur={handleBlur}
                                   onChange={handleChange}
                                   value={values.password}
                                   name="password"
                                   error={!!touched.password && !!errors.password}
                                   helperText={touched.password && errors.password}
                                   sx={{ gridColumn: "span 4" }}/>
                        {/* PASSWORD CONFIRM */}
                        <TextField fullWidth
                                   variant="filled"
                                   type="text"
                                   label="Confirm Password"
                                   onBlur={handleBlur}
                                   onChange={handleChange}
                                   value={values.confirm_password}
                                   name="confirm_password"
                                   error={!!touched.confirm_password && !!errors.confirm_password}
                                   helperText={touched.confirm_password && errors.confirm_password}
                                   sx={{ gridColumn: "span 4" }}/>
                    </Box>
                    <Box display="flex" justifyContent="end" mt="20px">
                        <Button type="submit" color="secondary" 
                                variant="contained">
                            REGISTER
                        </Button>
                    </Box>
                </form>
            )}
          </Formik>
        </Box>
      );
};

//const phoneRegExp = /^((\+[1-9]{1,4}[ -]?)|(\([0-9]{2,3}\)[ -]?)|([0-9]{2,4})[ -]?)*?[0-9]{3,4}[ -]?[0-9]{3,4}$/;
const emailRegExp = 
    /^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$/;

const checkoutSchema = yup.object().shape({
    name: yup.string().required("name required"),
    email: yup
        .string()
        .email("invalid email")
        .required("email required")
        .matches(emailRegExp, 'Invalid email'),
    password: yup
        .string()
        .required('password required'),
    confirm_password: yup
        .string()
        .required('confirm password required')
});

export default Login;