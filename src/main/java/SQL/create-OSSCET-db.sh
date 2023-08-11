#!/bin/bash
BASEDIR=$(dirname $0)
psql -U postgres -f "$BASEDIR/dropdb.sql" &&
createdb -U postgres osscet &&
psql -U postgres -d osscet -f "$BASEDIR/schema.sql" &&
psql -U postgres -d osscet -f "$BASEDIR/user.sql" &&
psql -U postgres -d osscet -f "$BASEDIR/data.sql"