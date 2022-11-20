import { useState, useEffect } from "react";
import { Box, Button } from "@mui/material";
import { DataGrid, GridToolbar } from "@mui/x-data-grid";
import { tokens } from "../../theme";
import Header from "../../components/Header";
import { useTheme } from "@mui/material";

import api from "../../api"

const Companies = () => {
    
    const theme = useTheme();
    const colors = tokens(theme.palette.mode);
    
    const [comps, setComps] = useState([]);

    useEffect(() => {
        const fetchCompanies = () => {
            try{
                api.get('/companies')
                .then(res => {
                    if( res && res.data ){
                        setComps(res.data);
                    }
                });
            }catch(err){
                console.log(`Error: ${err.message}`);
            }
        };
        fetchCompanies();
    }, []);

    const columns = [
        {
            field: "action", headerName: "Action", sortable: false,
            renderCell: (params) => {
                return <Button variant="contained">CLICK</Button>
            }
        },
        {field: "id",headerName: "ID", editable: true},
        {field: "name",headerName: "Name", sortable: true},
        {field: "status",headerName: "Status", sortable: false},
    ];
    return(
        <Box m="20px">
            <Header title="CONTACTS"
                    subtitle="List of Companies"/>
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
                    <DataGrid rows={comps}
                              checkboxSelection
                              columns={columns} 
                              components={{ Toolbar: GridToolbar }}/>
            </Box>
        </Box>
      );
};

export default Companies;