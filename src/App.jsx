if (module.hot) module.hot.accept();

import React, { useState, useEffect } from 'react';
import { render } from 'react-dom';

import Button from '@mui/material/Button';
import Paper from '@mui/material/Paper';
import { styled } from '@mui/material/styles';
import Grid from '@mui/material/Grid';
import Box from '@mui/material/Box';
import Typography from '@mui/material/Typography';

import TextField from '@mui/material/TextField';

import List from '@mui/material/List';
import ListItem from '@mui/material/ListItem';
import ListItemButton from '@mui/material/ListItemButton';
import ListItemText from '@mui/material/ListItemText';

import Dialog from '@mui/material/Dialog';
import DialogActions from '@mui/material/DialogActions';
import DialogContent from '@mui/material/DialogContent';
import DialogTitle from '@mui/material/DialogTitle';

import Backdrop from '@mui/material/Backdrop';
import CircularProgress from '@mui/material/CircularProgress';

import Link from '@mui/material/Link';

import { GoogleReCaptchaProvider } from 'react-google-recaptcha-v3';

import axios, { CancelToken } from 'axios';
import _ from 'underscore';

import './Components/app.scss';
import Topbar from './Components/Topbar';
import FeedbackListItem from './Components/FeedbackListItem';
import FeedbackLogin from './Components/FeedbackLogin';
import NoBoards from './Components/NoBoards';
import InputLabel from '@mui/material/InputLabel';
import FormControl from '@mui/material/FormControl';
import Select from '@mui/material/Select';
import MenuItem from '@mui/material/MenuItem';
import Divider from '@mui/material/Divider';

import SearchIcon from '@mui/icons-material/Search';
import ClearIcon from '@mui/icons-material/Clear';

import Snackbar from '@mui/material/Snackbar';
import Alert from '@mui/material/Alert';

const Item = styled(Paper)(({ theme }) => ({
    padding: theme.spacing(3),
    margin: theme.spacing(1),
    marginBottom: 'unset',
    color: theme.palette.text.secondary,
    boxShadow: 'unset',
    border: '1px solid #d7e1ec',
    ...theme.typography.body2,
}));

const ItemFeedbackList = styled(Paper)(({ theme }) => ({
    margin: theme.spacing(1),
    color: theme.palette.text.secondary,
    boxShadow: 'unset',
    border: '1px solid #d7e1ec',
    ...theme.typography.body2,
}));

export default function Appfront() {
    // Feedback
    const [open, setOpen] = React.useState(false);
    const [feedback, setFeedback] = React.useState('');

    // Login
    const [feedbackLoginOpen, setFeedbackLoginOpen] = React.useState(false);

    // Data
    const [feedbackListData, setFeedbackListData] = React.useState([]);
    const [initData, setInitData] = React.useState(false);
    const [lingual_data, setLingualData] = React.useState(false);

    const [authToken, setAuthToken] = React.useState(
        localStorage.authtoken && JSON.parse(localStorage.authtoken).authtoken != 'null'
            ? JSON.parse(localStorage.authtoken).authtoken
            : false
    );

    const [isLoading, setIsLoading] = React.useState(false);

    //Filter
    const [initRoadmap, setRoadMap] = React.useState([]);
    const [initSortedBy, setSortedBy] = React.useState('popularity');
    const [initFilterRoadmapId, setFilterRoadmapId] = React.useState('all');
    const [initFilterSearch, setFilterSearch] = React.useState('');
    const [initCategorySearch, setCategorySearch] = React.useState('all');
    const [dispSearch, setDispSearch] = React.useState(false);

    const [isLoading, setIsLoading] = useState(false);
    const [toastData, setToastData] = useState({});
    const [recordOffset, setRecordOffset] = useState(0);
    const [displayLoadmore, setDisplayLoadmore] = useState(false);
    const recordLimit = 20;

    const closeToastMessage = (event, reason) => {
        if (reason === 'clickaway') {
            return;
        }
        setToastData({});
    };

    useEffect(() => {
        if (board_data.id) {
            handleFilter();
        }
    }, ['feedbackListData']);

    const loadMoreFeedback = () => {
        handleFilter(undefined, undefined, recordOffset + recordLimit, true);
    };

    // loadFeedBacks = offset => {
    // var headers = {};
    // if (authToken) {
    // headers = { authtoken: authToken };
    // }
    // axios
    // .get(base_url + '/index.php/api/feedback/index/' + board_data.id + "/2/" + offset , {
    // headers: headers,
    // })
    // .then((res) => {
    // setFeedbackListData(res.data);
    // });
    // }

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
        setIsLoading(true);

        axios
            .get(`${base_url}/index.php/api/roadmap`)
            .then((res) => {
                return res.data;
            })
            .then((res) => {
                setRoadMap(res);
                setIsLoading(false);
            });
    }, ['initRoadmap']);

    const handleClose = () => {
        setOpen(false);
        setFeedbackLoginOpen(false);
    };

    const saveFeedback = () => {
        if (authToken) {
            setIsLoading(true);
            let formData = new FormData(); //formdata object
            formData.append('feedback_description', feedback); //append the values with key, value pair
            axios
                .post(base_url + '/index.php/api/' + board_data.id + '/feedback/save', formData, {
                    headers: { authtoken: authToken },
                })
                .then(() => {
                    setToastData({
                        type: 'success',
                        message: lingual_data.feedback_submitted,
                    });
                    setIsLoading(false);
                    handleClose();
                });
        }
        if (!authToken) {
            setFeedbackLoginOpen(true);
        }
    };

    const successCallback = () => {
        setFeedback('');
        setToastData({ type: 'success', message: lingual_data.feedback_submitted });
    };

    const setUpvote = (feedback_id, action, e) => {
        setIsLoading(true);
        if (authToken) {
            newFeedbackListData = _.map(feedbackListData, (feedback) => {
                if (feedback.id == feedback_id) {
                    feedback.disabled = true;
                }
                return feedback;
            });
            setFeedbackListData(newFeedbackListData);
            axios({
                method: action,
                url: base_url + '/index.php/api/ideas/' + feedback_id + '/vote',
                headers: { authtoken: authToken },
            }).then(() => {
                newFeedbackListData = _.map(feedbackListData, (feedback) => {
                    if (feedback.id == feedback_id) {
                        feedback.upvoted = action == 'post' ? '1' : '0';
                        feedback.upvotes =
                            action == 'post'
                                ? parseInt(feedback.upvotes) + 1
                                : parseInt(feedback.upvotes) - 1;
                        delete feedback.disabled;
                        setToastData({ type: 'success', message: lingual_data.thank_you_for_vote });
                    }
                    return feedback;
                });
                setFeedbackListData(newFeedbackListData);
            });
        }
        if (!authToken) {
            setToastData({ type: 'error', message: lingual_data.login_first_to_add_vote });
            document.getElementById('topbar_login').click();
        }
        setIsLoading(false);
    };

    const handleFilter = (e, category_id, offset, append = false) => {
        var value = '';
        var searchField = 'search';
        var record_offset = recordOffset;
        if (typeof offset != 'undefined') {
            record_offset = offset;
        }
        if (
            typeof e == 'undefined' &&
            typeof category_id == 'undefined' &&
            typeof offset == 'undefined'
        ) {
            record_offset = 0;
        }
        if (typeof e != 'undefined') {
            value = e.target.value;
            searchField = e.target.name;
            record_offset = 0;
        }
        if (typeof category_id != 'undefined') {
            value = category_id;
            record_offset = 0;
        }
        setRecordOffset(record_offset);
        var roadmap_id = initFilterRoadmapId;
        var sorted_by = initSortedBy;
        var filter_search = initFilterSearch;
        var category_search = initCategorySearch;
        if (!append) {
            if (searchField == 'roadmap_id') {
                setFilterRoadmapId(value);
                roadmap_id = value;
            }
            if (searchField == 'sorted_by') {
                setSortedBy(value);
                sorted_by = value;
            }
            if (searchField == 'search') {
                if (value.length <= 3 && value != '') {
                    return false;
                }
                setFilterSearch(value);
                filter_search = value;
            }
            if (typeof category_id != 'undefined') {
                setCategorySearch(value);
                category_search = value;
            }
        }
        var headers = {};
        if (authToken) {
            headers = { authtoken: authToken };
        }
        let formData = new FormData(); //formdata object
        formData.append('roadmap_id', roadmap_id);
        formData.append('sorting', sorted_by);
        formData.append('search', filter_search);
        formData.append('category_id', category_search);
        formData.append('offset', record_offset);
        formData.append('limit', recordLimit);
        setIsLoading(true);
        axios
            .post(base_url + '/index.php/api/feedback/index/' + board_data.id, formData, {
                headers: headers,
            })
            .then((res) => {
                if (append) {
                    setFeedbackListData([...feedbackListData, ...res.data.records]);
                } else {
                    setFeedbackListData(res.data.records);
                }
                setIsLoading(false);
                setDisplayLoadmore(record_offset + recordLimit < res.data.count);
            });
    };

    return (
        <>
            <Backdrop
                sx={{ color: '#fff', zIndex: (theme) => theme.zIndex.drawer + 1 }}
                open={isLoading}
            >
                <CircularProgress color="inherit" />
            </Backdrop>
            {initData ? (
                board_data.id ? (
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

                            <Grid
                                px={{ md: '10%', xs: '2%' }}
                                mt="1%"
                                container
                                spacing={2}
                                direction={'row-reverse'}
                            >
                                {/*Boards and Category*/}
                                <Grid item md={4} xs={12}>
                                    <Item
                                        elevation={3}
                                        style={{ backgroundColor: '#f2f4f9', textAlign: 'center' }}
                                    >
                                        <Typography style={{ fontSize: '16px' }}>
                                            {board_data.name}
                                        </Typography>
                                        <Typography style={{ fontSize: '14px',marginTop: '3%',color: "#666" }}>
                                            {board_data.intro_text}
                                        </Typography>
                                        <Button
                                            onClick={() => setOpen(true)}
                                            variant="contained"
                                            style={{
                                                fontSize: '12px',
                                                marginTop: '6%',
                                                background: '#03B7F2',
                                                padding: '9px 12px',
                                            }}
                                        >
                                            {lingual_data.make_a_suggestion}
                                        </Button>
                                    </Item>
                                    <Item
                                        style={{
                                            textAlign: 'center',
                                            margin: 'inherit unset',
                                            padding: 'unset',
                                            paddingTop: '5%',
                                            border: 'none',
                                            background: 'unset',
                                        }}
                                    >
                                        <List dense={true} style={{ padding: 'unset' }}>
                                            {categories ? (
                                                <>
                                                    <ListItem disablePadding>
                                                        <ListItemButton
                                                            style={{ padding: 'unset' }}
                                                            selected={initCategorySearch == 'all'}
                                                            key={'all'}
                                                            onClick={(e) => {
                                                                handleFilter(e, 'all');
                                                            }}
                                                        >
                                                            <ListItemText
                                                                primary={
                                                                    <Typography
                                                                        type="body2"
                                                                        style={{
                                                                            fontSize: '.875rem',
                                                                            padding: '16px 12px',
                                                                            color:
                                                                                initCategorySearch ==
                                                                                'all'
                                                                                    ? '#03B7F2'
                                                                                    : '#324057',
                                                                        }}
                                                                    >
                                                                        {
                                                                            lingual_data.all_categories
                                                                        }
                                                                    </Typography>
                                                                }
                                                            />
                                                        </ListItemButton>
                                                    </ListItem>
                                                    {categories.map((cat) => {
                                                        return (
                                                            <ListItem
                                                                key={cat.id}
                                                                secondaryAction={
                                                                    <Typography
                                                                        type="body2"
                                                                        style={{
                                                                            color:
                                                                                initCategorySearch ==
                                                                                cat.id
                                                                                    ? '#03B7F2'
                                                                                    : '#324057',
                                                                        }}
                                                                    >
                                                                        {cat.total_feedbacks}
                                                                    </Typography>
                                                                }
                                                                disablePadding
                                                                name="category"
                                                                value={cat.id}
                                                                onClick={(e) =>
                                                                    handleFilter(e, cat.id)
                                                                }
                                                            >
                                                                <ListItemButton
                                                                    style={{ padding: 'unset' }}
                                                                    selected={
                                                                        initCategorySearch == cat.id
                                                                    }
                                                                >
                                                                    <ListItemText
                                                                        primary={
                                                                            <Typography
                                                                                type="body2"
                                                                                style={{
                                                                                    fontSize:
                                                                                        '.875rem',
                                                                                    padding:
                                                                                        '16px 12px',
                                                                                    color:
                                                                                        initCategorySearch ==
                                                                                        cat.id
                                                                                            ? '#03B7F2'
                                                                                            : '#324057',
                                                                                }}
                                                                            >
                                                                                {cat.title}
                                                                            </Typography>
                                                                        }
                                                                    />
                                                                </ListItemButton>
                                                            </ListItem>
                                                        );
                                                    })}
                                                </>
                                            ) : (
                                                ''
                                            )}
                                        </List>
                                    </Item>
                                    {!initData.copyright_text.disable_copyright ? (
                                        <Box mt={2} textAlign="center" fontSize={'11.25px'}>
                                            <Box component={'span'} fontSize={'13px'}>
                                                ⚡
                                            </Box>
                                            <Link
                                                color="inherit"
                                                underline="none"
                                                target={'_blank'}
                                                href={
                                                    'https://themesic.com/idea-feedback-management-system'
                                                }
                                            >
                                                Powered by Idea FMS
                                            </Link>
                                        </Box>
                                    ) : (
                                        ''
                                    )}
                                </Grid>

                                {/*Suggestions*/}
                                <Grid item md={8} xs={12}>
                                    <Item
                                        sx={{
                                            padding: {
                                                md: '24px',
                                                xs: !dispSearch ? '10px' : '24px',
                                            },
                                        }}
                                    >
                                        <Box
                                            onClick={() => {
                                                setDispSearch((prevCheck) => !prevCheck);
                                                handleFilter();
                                            }}
                                            style={{ float: 'right', marginBottom: '15px' }}
                                            height={'1px'}
                                        >
                                            {dispSearch ? <ClearIcon /> : <SearchIcon />}
                                        </Box>
                                        <Box
                                            display={dispSearch ? 'flex' : 'none'}
                                            alignItems={'center'}
                                            fontSize={'14px'}
                                            height={'14px'}
                                        >
                                            <FormControl
                                                variant="standard"
                                                sx={{ m: 1, width: '100%' }}
                                            >
                                                <TextField
                                                    id="standard-basic"
                                                    name="search"
                                                    label={lingual_data.search}
                                                    variant="standard"
                                                    onChange={(e) => handleFilter(e)}
                                                />
                                            </FormControl>
                                        </Box>
                                        <Box
                                            display={
                                                !dispSearch
                                                    ? { xs: 'contents', md: 'flex' }
                                                    : 'none'
                                            }
                                            alignItems={'center'}
                                            fontSize={{ xs: '12px', md: 'inherit' }}
                                            height={'10px'}
                                            mt={'8px'}
                                        >
                                            <Box
                                                style={{ verticalAlign: 'sub' }}
                                                mr={1}
                                                component="span"
                                            >
                                                {lingual_data.show_me}
                                            </Box>
                                            <FormControl
                                                component="span"
                                                variant="standard"
                                                sx={{ mx: { md: 1, xs: 0 } }}
                                            >
                                                <Select
                                                    autoWidth={true}
                                                    defaultValue="all"
                                                    name="roadmap_id"
                                                    onChange={(e) => handleFilter(e)}
                                                    style={{ borderBottom: '1px dotted #ccc' }}
                                                    disableUnderline
                                                >
                                                    <MenuItem
                                                        key="all"
                                                        style={{ fontSize: '14px' }}
                                                        value="all"
                                                    >
                                                        {lingual_data.all}
                                                    </MenuItem>
                                                    {initRoadmap.map(function (data, key) {
                                                        return (
                                                            <MenuItem
                                                                style={{ fontSize: '14px' }}
                                                                key={data.id}
                                                                value={data.id}
                                                            >
                                                                {data.value}
                                                            </MenuItem>
                                                        );
                                                    })}
                                                </Select>
                                            </FormControl>
                                            <Typography
                                                component="span"
                                                dangerouslySetInnerHTML={{ __html: `<br>` }}
                                            ></Typography>
                                            <Box style={{ verticalAlign: 'sub' }} component="span">
                                                {lingual_data.Feedbacks},{' '}
                                            </Box>
                                            <Box
                                                style={{ verticalAlign: 'sub' }}
                                                sx={{ mr: { md: 1, xs: 0 } }}
                                                component="span"
                                            >
                                                {' '}
                                                {lingual_data.sorted_by}{' '}
                                            </Box>
                                            <FormControl variant="standard">
                                                <Select
                                                    autoWidth={true}
                                                    defaultValue="popularity"
                                                    name="sorted_by"
                                                    onChange={(e) => handleFilter(e)}
                                                    style={{ borderBottom: '1px dotted #ccc' }}
                                                    disableUnderline
                                                >
                                                    <MenuItem value="popularity">
                                                        {lingual_data.popularity}
                                                    </MenuItem>
                                                    <MenuItem value="DESC">
                                                        {lingual_data.vote_count}
                                                    </MenuItem>
                                                </Select>
                                            </FormControl>
                                        </Box>
                                    </Item>
                                    <ItemFeedbackList>
                                        <Box sx={{ width: '100%' }}>
                                            {feedbackListData.length ? (
                                                <>
                                                    {feedbackListData.map(function (data, key) {
                                                        return (
                                                            <FeedbackListItem
                                                                key={key}
                                                                setToastData={(type, message) =>
                                                                    setToastData(type, message)
                                                                }
                                                                feedbackData={data}
                                                                setUpvote={(
                                                                    feedback_id,
                                                                    action,
                                                                    e
                                                                ) =>
                                                                    setUpvote(
                                                                        feedback_id,
                                                                        action,
                                                                        e
                                                                    )
                                                                }
                                                                setIsLoading={(status) =>
                                                                    setIsLoading(status)
                                                                }
                                                                authToken={authToken}
                                                                board_data={board_data}
                                                                initData={initData}
                                                                setAuthToken={(token) =>
                                                                    setAuthToken(token)
                                                                }
                                                            />
                                                        );
                                                    })}
                                                    {displayLoadmore ? (
                                                        <Item
                                                            elevation={3}
                                                            style={{
                                                                textAlign: 'center',
                                                                margin: '2%',
                                                                padding: 'unset',
                                                                paddingTop: '5%',
                                                                border: 'none',
                                                                background: 'unset',
                                                            }}
                                                        >
                                                            <Button
                                                                onClick={loadMoreFeedback}
                                                                variant="contained"
                                                                color="info"
                                                            >
                                                                {lingual_data.loadMore
                                                                    ? lingual_data.loadMore
                                                                    : 'Load More'}
                                                            </Button>
                                                        </Item>
                                                    ) : (
                                                        ''
                                                    )}
                                                </>
                                            ) : (
                                                <Box color="#03b7f2" component={'h3'} p={2}>
                                                    {' '}
                                                    {initCategorySearch != 'all' ||
                                                    initFilterRoadmapId != 'all' ||
                                                    initFilterSearch != ''
                                                        ? lingual_data.no_result_found
                                                        : lingual_data.no_feedback_yet}
                                                </Box>
                                            )}
                                        </Box>
                                    </ItemFeedbackList>
                                </Grid>
                            </Grid>

                            {/*Add Suggestion Popup*/}
                            <Dialog
                                open={open}
                                onClose={handleClose}
                                maxWidth={'xs'}
                                fullWidth={true}
                            >
                                <DialogTitle>{lingual_data.leave_feedback}</DialogTitle>
                                <DialogContent>
                                    <TextField
                                        color="info"
                                        multiline
                                        rows={4}
                                        margin="dense"
                                        id="name"
                                        placeholder="Enter your feedback here"
                                        label="Feedback"
                                        fullWidth
                                        onChange={(e) => setFeedback(e.target.value)}
                                    />
                                </DialogContent>
                                <DialogActions>
                                    <Button onClick={handleClose}>{lingual_data.cancle}</Button>
                                    <Button
                                        disabled={feedback == ''}
                                        onClick={saveFeedback}
                                        variant="contained"
                                        color="info"
                                    >
                                        {lingual_data.submit}
                                    </Button>
                                </DialogActions>
                            </Dialog>

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
                                        setToastData={(type, message) =>
                                            setToastData(type, message)
                                        }
                                        guestAllowed={
                                            initData.allow_guest_posting.allow_guest_posting
                                        }
                                        setAuthToken={(token) => setAuthToken(token)}
                                        handleClose={() => handleClose()}
                                        feedback={feedback}
                                        type={'suggestion'}
                                        initData={initData}
                                        successCallback={() => successCallback()}
                                    />
                                </DialogContent>
                            </Dialog>
                        </Box>
                    </GoogleReCaptchaProvider>
                ) : (
                    <NoBoards initData={initData} />
                )
            ) : (
                ''
            )}
        </>
    );
}
render(<Appfront></Appfront>, document.querySelector('#root'));
