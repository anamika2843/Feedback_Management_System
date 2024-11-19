import React from 'react';
import { createTheme } from '@mui/material/styles';

import Button from '@mui/material/Button';
import Paper from '@mui/material/Paper';
import Grid from '@mui/material/Grid';
import Chip from '@mui/material/Chip';
import Typography from '@mui/material/Typography';

import Collapse from '@mui/material/Collapse';
import Box from '@mui/material/Box';
import TextField from '@mui/material/TextField';

import Link from '@mui/material/Link';

import List from '@mui/material/List';
import ListItem from '@mui/material/ListItem';
import Divider from '@mui/material/Divider';
import ListItemText from '@mui/material/ListItemText';
import ListItemAvatar from '@mui/material/ListItemAvatar';
import Avatar from '@mui/material/Avatar';
import Tooltip from '@mui/material/Tooltip';
import ExpandMoreIcon from '@mui/icons-material/ExpandMore';
import ExpandLessIcon from '@mui/icons-material/ExpandLess';

import KeyboardArrowUpIcon from '@mui/icons-material/KeyboardArrowUp';
import IconButton from '@mui/material/IconButton';
import LinkIcon from '@mui/icons-material/Link';
import { CopyToClipboard } from 'react-copy-to-clipboard';
import axios, { CancelToken } from 'axios';

import FeedbackLogin from './FeedbackLogin';
import ChatIcon from '@mui/icons-material/Chat';

function FeedbackListItem({
    feedbackData,
    setUpvote,
    setToastData,
    setIsLoading,
    authToken,
    board_data,
    initData,
    setAuthToken,
}) {
    const theme = createTheme();
    const [showLinkIcon, setLinkIcon] = React.useState(false);
    const [showUpvoteIcon, setUpvoteIcon] = React.useState(false);
    const [expanded, setExpanded] = React.useState(false);
    const [commentLoginOpen, setCommentLoginOpen] = React.useState(false);
    const [comment, setComment] = React.useState('');
    var lingual_data = initData.lingual_data;

    const successCallback = () => {
        setComment('');
        setIsLoading(false);
        setToastData({
            type: 'success',
            message: lingual_data.comment_moderate_message,
        });
        setExpanded(false);
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

    const saveComment = () => {
        if (authToken) {
            setIsLoading(true);
            let formData = new FormData(); //formdata object
            formData.append('description', comment); //append the values with key, value pair
            axios
                .post(
                    `${base_url}/index.php/api/${board_data.id}/ideas/${feedbackData.id}/feedback`,
                    formData,
                    { headers: { authtoken: authToken } }
                )
                .then(() => {
                    setCommentLoginOpen(false);
                    setComment('');
                    setIsLoading(false);
                    setToastData({
                        type: 'success',
                        message: lingual_data.comment_moderate_message,
                    });
                });
        }
        if (!authToken) {
            setCommentLoginOpen(true);
        }
    };

    return (
        <>
            <Paper
                sx={{
                    my: 0,
                    mx: 'auto',
                    p: 2,
                    pb: 4,
                    borderBottom: 'unset',
                    borderRadius: 'unset',
                    background: 'unset',
                }}
            >
                <Grid container>
                    <Grid item lg={1} md={2} sm={2} xs={3} className={'gridVoteButton'}>
                        <Button
                            disabled={feedbackData.disabled ? true : false}
                            onClick={(e) =>
                                setUpvote(
                                    feedbackData.id,
                                    feedbackData.upvoted == '1' ? 'delete' : 'post',
                                    e
                                )
                            }
                            color="info"
                            variant={feedbackData.upvoted == '1' ? 'contained' : 'outlined'}
                            startIcon={<KeyboardArrowUpIcon />}
                            onMouseOver={() => setUpvoteIcon(true)}
                            onMouseLeave={() => setUpvoteIcon(false)}
                        >
                            <span className="count">
                                {showUpvoteIcon ? '😍' : feedbackData.upvotes}
                            </span>
                        </Button>
                    </Grid>
                    <Grid item lg={11} md={10} sm={10} xs={9} className={'gridContent'}>
                        <Typography
                            style={{ marginBottom: 12 }}
                            onMouseOver={() => setLinkIcon(true)}
                            onMouseLeave={() => setLinkIcon(false)}
                        >
                            <Link
                                color="inherit"
                                underline="hover"
                                href={
                                    base_url +
                                    '/index.php/front/' +
                                    board_data.board_slug +
                                    '/feedback/' +
                                    feedbackData.id
                                }
                            >
                                {feedbackData.feedback.length > 50
                                    ? feedbackData.feedback.substring(0, 50) + '...'
                                    : feedbackData.feedback}
                            </Link>
                            <Box component="span" sx={{ display: { md: 'inline', xs: 'none' } }}>
                                {showLinkIcon ? (
                                    <CopyToClipboard
                                        text={
                                            base_url +
                                            '/index.php/front/' +
                                            board_data.board_slug +
                                            '/feedback/' +
                                            feedbackData.id
                                        }
                                        onCopy={() =>
                                            setToastData({
                                                type: 'success',
                                                message: lingual_data.copy_to_clipboard,
                                            })
                                        }
                                    >
                                        <IconButton aria-label="copy">
                                            <LinkIcon />
                                        </IconButton>
                                    </CopyToClipboard>
                                ) : (
                                    <IconButton style={{ opacity: 0 }} aria-label="copy">
                                        <LinkIcon />
                                    </IconButton>
                                )}
                            </Box>
                        </Typography>
                        {!expanded ? (
                            <>
                                <Tooltip title="Expand">
                                    <IconButton
                                        onClick={(e) => setExpanded(true)}
                                        style={{
                                            float: 'right',
                                            display: { md: 'inherit', xs: 'none' },
                                        }}
                                        aria-label="expand"
                                    >
                                        <ExpandMoreIcon
                                            sx={{ fontSize: { md: 'inherit', xs: '0.75rem' } }}
                                        />
                                    </IconButton>
                                </Tooltip>
                                <IconButton
                                    onClick={(e) => setExpanded(true)}
                                    style={{ float: 'right' }}
                                    aria-label="comment"
                                >
                                    <ChatIcon sx={{ fontSize: { md: 'inherit', xs: '1rem' } }} />
                                </IconButton>
                            </>
                        ) : (
                            <>
                                <Tooltip title="Collapse">
                                    <IconButton
                                        onClick={(e) => setExpanded(false)}
                                        style={{
                                            float: 'right',
                                            display: { md: 'inherit', xs: 'none' },
                                        }}
                                        aria-label="collapse"
                                    >
                                        <ExpandLessIcon
                                            sx={{ fontSize: { md: 'inherit', xs: '0.75rem' } }}
                                        />
                                    </IconButton>
                                </Tooltip>
                                <IconButton
                                    onClick={(e) => setExpanded(false)}
                                    style={{ float: 'right' }}
                                    aria-label="comment"
                                >
                                    <ChatIcon sx={{ fontSize: { md: 'inherit', xs: '1rem' } }} />
                                </IconButton>
                            </>
                        )}
                        {feedbackData.status_text != '' ? (
                            <Chip
                                sx={{
                                    backgroundColor: '#f9f9f9',
                                    padding: { md: '15px 5px', xs: 'unset' },
                                }}
                                label={feedbackData.status_icon + ' ' + feedbackData.status_text}
                            />
                        ) : (
                            ''
                        )}
                    </Grid>
                </Grid>
                <Grid container spacing={2}>
                    <Grid item lg={1} md={2} sm={2} xs={3}></Grid>
                    <Grid item lg={11} md={10} sm={10} xs={9}>
                        <Collapse in={expanded} timeout="auto" unmountOnExit>
                            {feedbackData.comments.length ? (
                                <Grid container spacing={2}>
                                    <Grid item xs>
                                        <List sx={{ width: '100%', bgcolor: 'background.paper' }}>
                                            {feedbackData.comments
                                                .slice(0, 3)
                                                .map(function (data, key) {
                                                    return (
                                                        <React.Fragment key={key}>
                                                            <ListItem alignItems="flex-start">
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
                                                                            : 'Anonymous user'
                                                                    }
                                                                    secondary={
                                                                        <React.Fragment>
                                                                            <Typography
                                                                                sx={{
                                                                                    display:
                                                                                        'inline',
                                                                                }}
                                                                                component="span"
                                                                                variant="body2"
                                                                                color="text.primary"
                                                                            >
                                                                                {data.commented_at}
                                                                            </Typography>
                                                                            {` — ${data.comment_description}`}
                                                                        </React.Fragment>
                                                                    }
                                                                />
                                                            </ListItem>
                                                            {key + 1 != 3 ? (
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
                                            {feedbackData.comments.length > 3 ? (
                                                <Link
                                                    color="inherit"
                                                    underline="hover"
                                                    style={{ float: 'right' }}
                                                    href={
                                                        base_url +
                                                        '/index.php/front/' +
                                                        board_data.board_slug +
                                                        '/feedback/' +
                                                        feedbackData.id
                                                    }
                                                >

                                                    <Chip
                                                        label={`${lingual_data.click_here_to_browse} ${
                                                            feedbackData.comments.length - 3
                                                        } ${lingual_data.other_comment}`}
                                                    ></Chip>
                                                </Link>
                                            ) : (
                                                ''
                                            )}
                                        </List>
                                    </Grid>
                                </Grid>
                            ) : (
                                ''
                            )}
                            {!commentLoginOpen ? (
                                <>
                                    <Box mb={1}>
                                        <TextField
                                            color="info"
                                            multiline
                                            rows={4}
                                            margin="dense"
                                            id="name"
                                            placeholder="Enter your Comment here"
                                            label="Comment"
                                            fullWidth
                                            value={comment}
                                            onChange={(e) => setComment(e.target.value)}
                                        />
                                    </Box>
                                    <Button
                                        disabled={comment == ''}
                                        onClick={saveComment}
                                        variant="contained"
                                    >
                                        {lingual_data.submit}
                                    </Button>
                                </>
                            ) : (
                                <FeedbackLogin
                                    setIsLoading={(status) => setIsLoading(status)}
                                    guestAllowed={
                                        initData.allow_guest_posting.allow_guest_commenting
                                    }
                                    setAuthToken={(token) => setAuthToken(token)}
                                    handleClose={() => setCommentLoginOpen(false)}
                                    feedback={comment}
                                    type={'comment'}
                                    feedback_data={feedbackData}
                                    initData={initData}
                                    successCallback={() => successCallback()}
                                />
                            )}
                        </Collapse>
                    </Grid>
                </Grid>
            </Paper>
        </>
    );
}

export default FeedbackListItem;
