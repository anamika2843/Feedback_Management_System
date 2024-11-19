if (module.hot) module.hot.accept();

import React, { useState, useEffect } from 'react';
import { render } from 'react-dom';

import Button from '@mui/material/Button';
import Box from '@mui/material/Box';
import Grid from '@mui/material/Grid';
import Divider from '@mui/material/Divider';
import Chip from '@mui/material/Chip';
import TextField from '@mui/material/TextField';
import FormControlLabel from '@mui/material/FormControlLabel';
import Checkbox from '@mui/material/Checkbox';

import Paper from '@mui/material/Paper';
import { styled } from '@mui/material/styles';

import Dialog from '@mui/material/Dialog';
import DialogActions from '@mui/material/DialogActions';
import DialogContent from '@mui/material/DialogContent';
import DialogTitle from '@mui/material/DialogTitle';

import KeyboardArrowUpIcon from '@mui/icons-material/KeyboardArrowUp';
import axios, { CancelToken } from 'axios';
import { GoogleReCaptchaProvider } from 'react-google-recaptcha-v3';

import Topbar from './Components/Topbar';
import NoBoards from './Components/NoBoards';
import FeedbackLogin from './Components/FeedbackLogin';

import List from '@mui/material/List';
import ListItem from '@mui/material/ListItem';
import ListItemText from '@mui/material/ListItemText';
import ListItemAvatar from '@mui/material/ListItemAvatar';
import Avatar from '@mui/material/Avatar';

import Backdrop from '@mui/material/Backdrop';
import CircularProgress from '@mui/material/CircularProgress';

import Typography from '@mui/material/Typography';
import _ from 'underscore';

import Snackbar from '@mui/material/Snackbar';
import Alert from '@mui/material/Alert';

import Breadcrumbs from '@mui/material/Breadcrumbs';
import Link from '@mui/material/Link';

export default function SingleFeedback() {
    const [initData, setInitData] = React.useState(false);
    const [lingual_data, setLingualData] = React.useState(false);
    const [authToken, setAuthToken] = React.useState(
        localStorage.authtoken && JSON.parse(localStorage.authtoken).authtoken != 'null'
            ? JSON.parse(localStorage.authtoken).authtoken
            : false
    );
    const [isLoading, setIsLoading] = React.useState(false);
    const [feedbackListData, setFeedbackListData] = React.useState([]);
    const [feedback, setFeedback] = React.useState('');
    const [checked, setChecked] = React.useState(!authToken ? true : false);

    const [feedbackLoginOpen, setFeedbackLoginOpen] = React.useState(false);
    const [showUpvoteIcon, setUpvoteIcon] = React.useState(false);

    //Loading & Toast
    const [isLoading, setIsLoading] = React.useState(false);
    const [toastData, setToastData] = React.useState({});
    useEffect(() => {
        setIsLoading(true);
        axios
            .get(base_url + '/index.php/api/settings')
            .then((res) => {
                return res.data;
            })
            .then((res) => {
                setLingualData(res.lingual_data);
                setInitData(res);
                setIsLoading(false);
            });
    }, ['initData']);

    useEffect(() => {
        if (board_data.id) {
            var headers = {};
            let formData = new FormData();
            formData.append('feedback_id', feedback_data.id);
            if (authToken) {
                headers = { authtoken: authToken };
            }
            axios
                .post(base_url + '/index.php/api/feedback/index/' + board_data.id, formData, {
                    headers: headers,
                })
                .then((res) => {
                    var data = _.first(res.data.records);
                    setFeedbackListData(data);
                });
        }
    }, ['feedbackListData']);

    const Item = styled(Paper)(({ theme }) => ({
        margin: theme.spacing(1),
        marginBottom: 'unset',
        color: theme.palette.text.secondary,
        boxShadow: 'unset',
        border: '1px solid #d7e1ec',
        ...theme.typography.body2,
    }));

    const saveComment = () => {
        if (authToken) {
            setIsLoading(true);
            let formData = new FormData(); //formdata object
            formData.append('description', feedback); //append the values with key, value pair
            axios
                .post(
                    `${base_url}/index.php/api/${board_data.id}/ideas/${feedback_data.id}/feedback`,
                    formData,
                    { headers: { authtoken: authToken } }
                )
                .then(() => {
                    setFeedback('');
                    setChecked(false);
                    setIsLoading(false);
                    setToastData({
                        type: 'success',
                        message: lingual_data.comment_moderate_message,
                    });
                });
        }
        if (!authToken) {
            setFeedbackLoginOpen(true);
        }
    };

    const closeToastMessage = (event, reason) => {
        if (reason === 'clickaway') {
            return;
        }
        setToastData({});
    };

    const handleClose = () => {
        setFeedbackLoginOpen(false);
    };

    const successCallback = () => {
        setFeedback('');
        setChecked(false);
        setIsLoading(false);
        setToastData({
            type: 'success',
            message: lingual_data.comment_moderate_message,
        });
    };

    const logout = () => {
        localStorage.removeItem('authtoken');
        setAuthToken(false);
        setToastData({ type: 'success', message: lingual_data.logged_out });
    };

    const stringToColor = (string) => {
        let hash = 0;
        let i;
        if (!string) {
            string = '-';
        }

        for (i = 0; i < string.length; i += 1) {
            hash = string.charCodeAt(i) + ((hash << 5) - hash);
        }

        let color = '#';

        for (i = 0; i < 3; i += 1) {
            const value = (hash >> (i * 8)) & 0xff;
            color += `00${value.toString(16)}`.slice(-2);
        }

        return color;
    };

    const stringAvatar = (name) => {
        return {
            sx: {
                bgcolor: stringToColor(name),
            },
            children: name
                ? name.split(' ')[1]
                    ? `${name.split(' ')[0][0]}${name.split(' ')[1][0]}`
                    : `${name.split(' ')[0][0]}`
                : '-',
        };
    };

    const setUpvote = (feedback_id, action, e) => {
        setIsLoading(true);
        if (authToken) {
            newFeedbackListData = feedbackListData;
            newFeedbackListData.disabled = true;
            setFeedbackListData(newFeedbackListData);
            axios({
                method: action,
                url: base_url + '/index.php/api/ideas/' + feedback_id + '/vote',
                headers: { authtoken: authToken },
            }).then(() => {
                newFeedbackListData = feedbackListData;
                feedbackListData.upvoted = action == 'post' ? '1' : '0';
                feedbackListData.upvotes =
                    action == 'post'
                        ? parseInt(feedbackListData.upvotes) + 1
                        : parseInt(feedbackListData.upvotes) - 1;
                delete feedbackListData.disabled;
                setToastData({ type: 'success', message: lingual_data.thank_you_for_vote });
                setFeedbackListData(newFeedbackListData);
            });
        }
        if (!authToken) {
            setToastData({ type: 'error', message: lingual_data.login_first_to_add_vote });
            document.getElementById('topbar_login').click();
        }
        setIsLoading(false);
    };

    return initData ? (
        board_data.id ? (
            <>
                <Backdrop
                    sx={{ color: '#fff', zIndex: (theme) => theme.zIndex.drawer + 1 }}
                    open={isLoading}
                >
                    <CircularProgress color="inherit" />
                </Backdrop>
                <Snackbar
                    open={typeof toastData.type != 'undefined'}
                    autoHideDuration={6000}
                    onClose={closeToastMessage}
                    anchorOrigin={{ vertical: 'top', horizontal: 'right' }}
                >
                    <Alert
                        variant="filled"
                        onClose={closeToastMessage}
                        icon={false}
                        severity={toastData.type ? toastData.type : 'error'}
                        style={{ fontSize: 15 }}
                    >
                        {toastData.message ? toastData.message : ''}
                    </Alert>
                </Snackbar>
                <GoogleReCaptchaProvider
                    reCaptchaKey={initData.recaptcha.recaptcha_site_key}
                    useEnterprise={false}
                >
                    <Box sx={{ flexGrow: 1 }} bgcolor={'#F9FAFC'} mb={10}>
                        <Topbar
                            initData={initData}
                            authToken={authToken}
                            setAuthToken={(token) => setAuthToken(token)}
                        />

                        <Grid px={{ md: '14%', xs: '4%' }} mt="1%" container spacing={2}>
                            <Grid item lg={12}>
                                <Breadcrumbs aria-label="breadcrumb" sx={{ padding: '2px 8px' }}>
                                    <Link
                                        underline="hover"
                                        color="inherit"
                                        href={`${base_url}/index.php/front/boards/${board_data.board_slug}`}
                                    >
                                        {board_data.name}
                                    </Link>
                                    <Typography color="text.primary">
                                        {feedbackListData.feedback &&
                                        feedbackListData.feedback.length > 50
                                            ? feedbackListData.feedback.substring(0, 50) + '...'
                                            : feedbackListData.feedback}
                                    </Typography>
                                </Breadcrumbs>
                                <Divider />
                            </Grid>
                        </Grid>
                        <Grid px={{ md: '28%', xs: '4%' }} mt="1%" container spacing={2}>
                            <Grid
                                item
                                lg={2}
                                sx={{
                                    width: { xs: '100%', md: 'inherit' },
                                    textAlign: { xs: 'center', md: 'inherit' },
                                }}
                            >
                                <Button
                                    disabled={feedbackListData.disabled ? true : false}
                                    onClick={(e) =>
                                        setUpvote(
                                            feedbackListData.id,
                                            feedbackListData.upvoted == '1' ? 'delete' : 'post',
                                            e
                                        )
                                    }
                                    color="info"
                                    variant={
                                        feedbackListData.upvoted == '1' ? 'contained' : 'outlined'
                                    }
                                    startIcon={<KeyboardArrowUpIcon />}
                                    onMouseOver={() => setUpvoteIcon(true)}
                                    onMouseLeave={() => setUpvoteIcon(false)}
                                >
                                    <span className="count">
                                        {showUpvoteIcon ? '😍' : feedbackListData.upvotes}
                                    </span>
                                </Button>
                            </Grid>
                            <Grid item lg={10}>
                                <Box borderRadius={'4px'} border={'1px solid #d7e1ec'}>
                                    <Box p={3} borderBottom={'1px solid #d7e1ec'} bgcolor={'#fff'}>
                                        <Typography
                                            variant={'h5'}
                                            sx={{
                                                marginBottom: 2,
                                                fontSize: { xs: '1rem', md: '1.25rem' },
                                            }}
                                        >
                                            {feedbackListData.feedback}
                                        </Typography>
                                        {feedbackListData.status_text != '' ? (
                                            <Chip
                                                style={{
                                                    backgroundColor: '#f9f9f9',
                                                    padding: '15px 5px',
                                                }}
                                                color="default"
                                                size="small"
                                                label={
                                                    feedbackListData.status_icon +
                                                    ' ' +
                                                    feedbackListData.status_text
                                                }
                                            />
                                        ) : (
                                            ''
                                        )}
                                    </Box>
                                    {feedbackListData.id && feedbackListData.comments.length ? (
                                        <Box borderBottom={'1px solid #d7e1ec'} bgcolor={'#fff'}>
                                            <List sx={{ width: '90%', marginLeft: '5%' }}>
                                                {feedbackListData.comments.map(function (
                                                    data,
                                                    key
                                                ) {
                                                    return (
                                                        <React.Fragment key={key}>
                                                            <ListItem>
                                                                <ListItemAvatar>
                                                                    <Avatar
                                                                        {...stringAvatar(
                                                                            data.user_name
                                                                        )}
                                                                    />
                                                                </ListItemAvatar>
                                                                <ListItemText
                                                                    primary={
                                                                        data.user_name != null &&
                                                                        data.user_name != ''
                                                                            ? data.user_name
                                                                            : lingual_data.anonymous_user
                                                                    }
                                                                    primaryTypographyProps={{
                                                                        sx: {
                                                                            fontWeight: 'bolder',
                                                                            fontSize: {
                                                                                md: 'inherit',
                                                                                xs: '0.875rem',
                                                                            },
                                                                        },
                                                                    }}
                                                                    secondaryTypographyProps={{
                                                                        sx: {
                                                                            fontSize: {
                                                                                md: 'inherit',
                                                                                xs: '0.875rem',
                                                                            },
                                                                        },
                                                                    }}
                                                                    secondary={
                                                                        <React.Fragment>
                                                                            <Typography
                                                                                sx={{
                                                                                    display:
                                                                                        'inline',
                                                                                    fontWeight:
                                                                                        'bolder',
                                                                                    fontSize: {
                                                                                        md: 'inherit',
                                                                                        xs: '0.875rem',
                                                                                    },
                                                                                }}
                                                                                component="span"
                                                                            >
                                                                                {data.commented_at}
                                                                            </Typography>
                                                                            {` — ${data.comment_description}`}
                                                                        </React.Fragment>
                                                                    }
                                                                />
                                                            </ListItem>
                                                            {key + 1 !=
                                                            feedbackListData.comments.length ? (
                                                                <Divider
                                                                    style={{
                                                                        borderColor: '#f9f9f9',
                                                                    }}
                                                                />
                                                            ) : (
                                                                ''
                                                            )}
                                                        </React.Fragment>
                                                    );
                                                })}
                                            </List>
                                        </Box>
                                    ) : (
                                        ''
                                    )}
                                    <Box bgcolor={'#f9f9f9'} p={3}>
                                        <Typography style={{ marginBottom: 12 }}>
                                            {lingual_data.Leave_Comment}
                                        </Typography>
                                        <TextField
                                            color="info"
                                            multiline
                                            rows={4}
                                            margin="dense"
                                            id="name"
                                            placeholder="Enter your Comment here"
                                            label="Comment"
                                            fullWidth
                                            value={feedback}
                                            onChange={(e) => setFeedback(e.target.value)}
                                        />
                                        {authToken ? (
                                            <Box>
                                                <Box>
                                                    Posting as{' '}
                                                    {JSON.parse(localStorage.authtoken).email}{' '}
                                                    <Button onClick={logout} variant="text">
                                                        {lingual_data.logout}
                                                    </Button>
                                                </Box>
                                                <FormControlLabel
                                                    control={
                                                        <Checkbox
                                                            checked={checked}
                                                            onChange={(e) =>
                                                                setChecked(e.target.checked)
                                                            }
                                                        />
                                                    }
                                                    label={lingual_data.i_agree_terms_of_service}
                                                />
                                            </Box>
                                        ) : (
                                            ''
                                        )}
                                        <Button
                                            disabled={feedback == '' || !checked}
                                            onClick={saveComment}
                                            variant="contained"
                                        >
                                            {lingual_data.submit}
                                        </Button>
                                    </Box>
                                </Box>
                            </Grid>
                        </Grid>

                        {/*login popup after feedback*/}
                        <Dialog
                            open={feedbackLoginOpen}
                            onClose={handleClose}
                            maxWidth={'sm'}
                            fullWidth={true}
                        >
                            <DialogContent>
                                <FeedbackLogin
                                    setIsLoading={(status) => setIsLoading(status)}
                                    guestAllowed={
                                        initData.allow_guest_posting.allow_guest_commenting
                                    }
                                    setAuthToken={(token) => setAuthToken(token)}
                                    handleClose={() => handleClose()}
                                    feedback={feedback}
                                    type={'comment'}
                                    feedback_data={feedback_data}
                                    initData={initData}
                                    successCallback={() => successCallback()}
                                />
                            </DialogContent>
                        </Dialog>
                    </Box>
                </GoogleReCaptchaProvider>
            </>
        ) : (
            <NoBoards />
        )
    ) : (
        ''
    );
}

render(<SingleFeedback></SingleFeedback>, document.querySelector('#root'));
