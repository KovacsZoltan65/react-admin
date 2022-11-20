import { useState, useEffect } from "react";
import { Box, Button } from "@mui/material";
import { DataGrid, GridToolbar } from "@mui/x-data-grid";
import { tokens } from "../../theme";
import Header from "../../components/Header";
import { useTheme } from "@mui/material";
import api from "../../api";

const Countries = () => {
    const theme = useTheme();
    const colors = tokens(theme.palette.mode);
    const {countries, setCountries} = useState([]);

    useEffect(() => {
        const fetchCountries = () => {
            try{
                api.get("/currencies")
                .then(res => {
                    if( res && res.data ){
                        setCountries(res.data);
                    }
                });
            }catch(err){
                console.log(`Error: ${err.message}`);
            }
        };
    }, []);

    const columns = [
        //{field: "id", headerName: "", sortable: true},
        //{field: "lang_hu", headerName: "", sortable: true},
        //{field: "lang_orig", headerName: "", sortable: true},
        {field: "country_hu", headerName: "hu", sortable: true},
        {field: "country_orig", headerName: "orig", sortable: true},
        {field: "country_short", headerName: "Short", sortable: true},
        {field: "currency", headerName: "Currency", sortable: true},
        {field: "vat_region", headerName: "VAT", sortable: true},
        {field: "status", headerName: "Status", sortable: true},
    ];

    return(<Box m="20px">
        <Header title="COUNTRIES" 
                subtitle="List of Countries"/>
        <Box m="40px 0 0 0" 
             height="75vh" 
             sx={{
                "& .MuiDataGrid-root": {
                    border: "none",
                },
                "& .MuiDataGrid-cell": {
                    borderBottom: "none",
                },
                "& .name-column--cell": {
                    color: colors.greenAccent[300],
                },
                "& .MuiDataGrid-columnHeaders": {
                    backgroundColor: colors.blueAccent[700],
                    borderBottom: "none",
                },
                "& .MuiDataGrid-virtualScroller": {
                    backgroundColor: colors.primary[400],
                },
                "& .MuiDataGrid-footerContainer": {
                    borderTop: "none",
                    backgroundColor: colors.blueAccent[700],
                },
                "& .MuiCheckbox-root": {
                    color: `${colors.greenAccent[200]} !important`,
                },
                "& .MuiDataGrid-toolbarContainer .MuiButton-text": {
                    color: `${colors.grey[100]} !important`,
                },
            }}>
            <DataGrid rows={countries} 
                      checkboxSelection 
                      columns={columns} 
                      components={{ Toolbar: GridToolbar }}/>
        </Box>
    </Box>);
};

export default Countries;