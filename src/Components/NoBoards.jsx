import React from 'react';
import { makeStyles } from '@mui/styles';

import Grid from '@mui/material/Grid';
import Box from '@mui/material/Box';

const useStyles = makeStyles({
    root: {
        minWidth: '100%',
        minHeight: '100vh',
        display: 'flex',
        flexDirection: 'column',
        justifyContent: 'center',
    },
    card: {
        maxWidth: '40%',
        display: 'flex',
        alignItems: 'center',
    },
});

export default function NoBoards({ initData }) {
    const classes = useStyles();
    var lingual_data = initData.lingual_data;

    return (
        <Grid className={classes.root} alignItems="center" justify="center">
            <Box color="#ed6c02" component={'h1'} className={classes.card}>
                {lingual_data.no_public_board}
            </Box>
        </Grid>
    );
}
