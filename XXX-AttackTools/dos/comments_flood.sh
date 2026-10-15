#!/bin/bash

URL="http://localhost:8000/articles/11/comments"
NUM_REQUESTS=100
CSRF_TOKEN="eqREXJiEcqeKuhS4kubRmuBULSWkxzMIOBHFRrTY"
SESSION_COOKIE="laravel_session=eyJpdiI6Ijh0TjE4SFAxWlpROHlHbk5lSi80WEE9PSIsInZhbHVlIjoiOTRnRzhQSW0yZUI4QUh2MTVOcEd2Z2VqdEYxejRhSHBXdjFCSm1ybDhoa1J5MHV3N2QxUDZlU3g1SVU2WU9lVTBNYjJPNHRyKzdkdThNckl0TXNObnN1eVZ4MWlyYi9SYVQ4cS9RS0FRbDZIY1Y3bE5tRWwycU1xdW4rNVdrWEUiLCJtYWMiOiIzNDI3MzY5ODM1YTRmMTRmYWQzOTNkODFmYTQ0MDdhOGIyYTllY2Y3NmNhY2YzZWNmNWFmNjFjNjEyNDYxNTg2IiwidGFnIjoiIn0%3D"

send_comment(){
    local comment_number=$1
    curl -s -H "Cookie: $SESSION_COOKIE" -X POST -d "content= commento casuale $1&_token=$CSRF_TOKEN" "$URL"
}

for ((i=1; i<=NUM_REQUESTS; i++))
do
    send_comment $i
    if [ $((i % 5)) -eq 0 ]; then
        echo "Sent 5 comments, waiting for 1 minute..."
        sleep 60
    fi
    echo "Comment $i sent"
done
