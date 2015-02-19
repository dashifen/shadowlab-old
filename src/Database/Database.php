<?php

namespace Shadowlab\Database;

use Shadowlab\Exceptions\DatabaseException;

/**
 * Class Database
 * @package Shadowlab\Database
 */
class Database extends AbstractMysqlDatabase
{
    /**
     * @var array
     */
    protected $types = [];

    /**
     * @var array
     */
    protected $bindings = [];

    /**
     * @param array $bindings
     */
    public function setBindings(array $bindings)
    {
        $this->bindings = $bindings;
    }

    /**
     * @param array $types
     */
    public function setTypes(array $types)
    {
        $this->types = $types;
    }

    /**
     * @param $query
     * @return bool|\mysqli_result
     * @throws DatabaseException
     */
    public function runQuery($query)
    {
        if(sizeof($this->types) == sizeof($this->bindings)) {
            // as long as we have the same number of types as we do bindings, we're good to go.
            // since types is, currently, an array but the bind_param() method expects a string,
            // we'll join that one.  but, it wants the individual values to be bound into the
            // query separately, so we'll use the splat operator to break up our array and pass
            // them to the method.

            try {
                $types = join('', $this->types);
                $statement = $this->db->prepare($query);
                $statement->bind_param($types, ...$this->bindings);
                $success = $statement->execute();
            } catch (\Exception $e) {
                // if we couldn't execute our query, we want to re-throw this exception but with a
                // little bit more context-sensitive information re: the query.  the only problem is
                // that it's more helpful if our query has the bound parameters in its content.  so,
                // we'll switch the ? SQL placeholders for %s's and then we can use vsprintf() to make
                // a fully complete query for our error report.

                $query = str_replace("?", "%s", $query);
                $query = vsprintf($query, $this->bindings);
                throw new DatabaseException("Unable to execute query.", $query, $e);
            }

            // $success is boolean so if it's true, we want to actually get our results.
            // otherwise, we'll set it explicitly to false before closing our statement and
            // then return our results.

            $results = $success
                ? $statement->get_result()
                : false;

            $statement->close();
            return $results;
        }

        // if our size of types and bindings didn't match then we've got a problem.  this probably
        // only happens when we hand-write our own queries, but even in that rare case it's worth
        // testing.

        throw new DatabaseException("Length of types and bindings unmatched");
    }

    /**
     * @param $column
     * @param null $table
     * @param array $criteria
     * @param array $orderby
     * @return bool
     * @throws DatabaseException
     */
    public function getVar($column, $table = null, array $criteria = [], array $orderby = [])
    {
        if(!is_string($column)) throw new DatabaseException("Cannot use getVar() for multiple columns");

        // for this and our other selection methods, we just pass all of our arguments onto the
        // buildSelect method.  we'll splat them to reduce the changes necessary if we add new arguments
        // later.

        $query = $this->buildSelect(...func_get_args());
        $results = $this->runQuery($query);
        if($results === false) return false;

        // the purpose of this method is to return a single variable.  therefore, we're going to do so
        // by getting the first row of the results and then returning the first value therein.

        $row = $results->fetch_row();
        return $row[0];
    }

    /**
     * @param $column
     * @param $table
     * @param array $criteria
     * @param array $orderby
     * @return array|bool
     * @throws DatabaseException
     */
    public function getCol($column, $table, array $criteria = [], array $orderby = [])
    {
        if(!is_string($column)) throw new DatabaseException("Cannot use getCol() for multiple columns");
        $query = $this->buildSelect(...func_get_args());
        $results = $this->runQuery($query);
        if($results === false) return false;

        // for this method we want to return the information from a single column.  because $column
        // is a single string, we know that's all we selected.  but, the fetch_all() method called
        // be low gives us an array of arrays.  we'll need to flatten that result before we return it.
        // the source for this flatten algorithm is here: http://stackoverflow.com/a/1320156/360838.

        $retval = [];
        $results = $results->fetch_all(MYSQL_NUM);
        array_walk_recursive($results, function($x) use (&$retval) { $retval[] = $x; });
        return $retval;
    }

    /**
     * @param array $columns
     * @param $table
     * @param array $criteria
     * @param array $orderby
     * @return array|bool
     * @throws DatabaseException
     */
    public function getRow(array $columns, $table, array $criteria = [], array $orderby = [])
    {
        $query = $this->buildSelect(...func_get_args());
        $results = $this->runQuery($query);

        // unlike the prior two methods, we return an associative array here.  the earlier two
        // methods turned only one value or one set of values from the same column.  we assume the
        // calling scope can figure that out.  but, here we return an associative array so it's
        // clear what things are what.  the calling scope can always use array_values() if they
        // need to.

        return $results !== false
            ? $results->fetch_assoc()
            : false;
    }

    /**
     * @param array $columns
     * @param $table
     * @param array $criteria
     * @param array $orderby
     * @return bool|mixed
     * @throws DatabaseException
     */
    public function getResults(array $columns, $table, array $criteria = [], array $orderby = [])
    {
        $query = $this->buildSelect(...func_get_args());
        $results = $this->runQuery($query);
        return $results !== false
            ? $results->fetch_all(MYSQL_ASSOC)
            : false;
    }

    /**
     * @param $table
     * @param array $values
     * @return bool|mixed
     * @throws DatabaseException
     */
    public function insert($table, array $values)
    {
        $this->resetQuery();

        // the insert query begins the same as an upsert query.  to avoid repeating the construction of that
        // (part of) the query, we'll use the method below as a builder here and in upsert() below.

        $query = $this->buildInsert($table, $values);
        $results = $this->runQuery($query);
        if($results === false) return false;

        // if we only affected a single row, then we'll return that row's id.  otherwise, we return true
        // and the calling scope will need to figure out what it wants to do from there.

        return $this->getAffectedRows()==1
            ? $this->getInsertedId()
            : true;
    }

    /**
     * @param $table
     * @param array $values
     * @param array $criteria
     * @return bool|int
     * @throws DatabaseException
     */
    public function update($table, array $values, array $criteria = [])
    {
        $this->resetQuery();

        // for this method, we actually have to set types and bindings for both the $values and the
        // $criteria.  this is because we'll need them in both the SET as well as the WHERE clause.
        // we'll call setTypesAndBindings here with $values and, if we have a WHERE clause to build,
        // the buildWhere() class will add on that information later.

        $this->setTypesAndBindings($values);

        $temp = [];
        $columns = array_keys($values);
        $query = "UPDATE {$table} SET ";
        foreach($columns as $column) $temp[] = "{$column} = ?";
        $query .= join(", ", $temp);

        if(sizeof($criteria) > 0) $query .= "WHERE " . $this->buildWhere($criteria) . " ";
        $results = $this->runQuery($query);

        // we'll return the number of affected rows from this method.  in a lot of cases this might
        // double for a boolean (i.e. if we updated 6 rows then the returned number is truthy) but it
        // could be problematic if there were zero rows affected.  but, that's sort of like a failed
        // query so maybe that's okay.

        return $results !== false
            ? $this->getAffectedRows()
            : false;
    }

    /**
     * @param $table
     * @param array $criteria
     * @param null $limit
     * @param null $offset
     * @return bool|int
     * @throws DatabaseException
     */
    public function delete($table, array $criteria = [], $limit = null, $offset = null)
    {
        $this->resetQuery();
        $query = "DELETE FROM {$table} ";
        if(sizeof($criteria) > 0) $query .= "WHERE " . $this->buildWhere($criteria) . " ";
        if($limit != null)  $query .= "LIMIT {$limit} ";
        if($offset != null) $query .= "OFFSET {$offset} ";

        $results = $this->runQuery($query);
        return $results !== false
            ? $this->getAffectedRows()
            : false;
    }

    /**
     * @param $table
     * @param array $values
     * @param array $updates
     * @return bool|int
     * @throws DatabaseException
     */
    public function upsert($table, array $values, array $updates = [])
    {
        $this->resetQuery();

        // an upsert is a combination of inserts and updates when a duplicate key is found.  we'll use
        // the buildInsert method below to make the first half of the query and then we'll add on the rest
        // of the query thereafter.

        $query  = $this->buildInsert($table, $values);

        // if we don't have any specified information to update, then we'll make sure all of the values
        // are updated.  unlike a normal update query, an upsert does not use the keyword "SET."  instead,
        // the column and value pairs are added immediately after the following phrase.

        $temp = [];
        $query .= " ON DUPLICATE KEY UPDATE ";
        if(sizeof($updates)==0) $updates = $values;
        foreach($updates as $column => $value) $temp[] = "{$column} = ?";
        $query .= join(", ", $temp);

        // the last thing we do before we execute our query is to make sure the values we just added to
        // the query for updating are bound to the query, too.  then we can execute our query and, if it
        // works, we return the number of affected rows

        $this->setTypesAndBindings($updates);
        $results = $this->runQuery($query);
        return $results !== false
            ? $this->getAffectedRows()
            : false;
    }

    /**
     * @param $columns
     * @param $table
     * @param array $criteria
     * @param array $orderby
     * @return string
     * @throws DatabaseException
     */
    protected function buildSelect($columns, $table, array $criteria = [], array $orderby = [])
    {
        $this->resetQuery();

        // our queries always start by selecting columns.  we need to be prepared to handle both a
        // single column as well as a set of columns to select as follows.

        $query  = "SELECT ";
        $query .= is_array($columns) ? join(', ', $columns) : $columns;
        $query .= " ";

        // the getVar method above might send us here with nothing other than a column to select.  this
        // happens when we're grabbing the results of a routine of some sort (e.g. SELECT NOW()).  as
        // such, we have to be careful to double-check that we have a table from which to select before
        // we make assumptions.

        if($table != null) $query .= "FROM {$table} ";
        if(sizeof($criteria)) $query .= "WHERE " . $this->buildWhere($criteria) . " ";
        if(sizeof($orderby)) $query .= "ORDER BY " . join(", ", $orderby);
        return $query;
    }

    /**
     * @param $table
     * @param $values
     * @return string
     */
    protected function buildInsert($table, $values)
    {
        $columns = array_keys($values);
        $this->setTypesAndBindings($values);
        $query  = "INSERT INTO {$table} (" . join(", ", $columns) . ") VALUES ";
        $query .= "(" . join(", ", array_fill(0, sizeof($columns), '?')) . ")";
        return $query;
    }

    /**
     * @param $criteria
     * @return string
     * @throws DatabaseException
     */
    protected function buildWhere($criteria)
    {
        $temp = [];
        foreach($criteria as $column => $value) {
            // most of the time, $value is a scalar value representing the value that $column must have
            // to satisfy this part of our WHERE clause.  but, if $value is an array, then the first index
            // is the value to match against column and the second is the comparison that we're making
            // against that value.  those comparisons are equal, not-equal, less than, less than or equal
            // to, greater than or equal to, greater than, LIKE, and IN.

            if(!is_array($value)) $comparison = "=";
            else list($value, $comparison) = $value;
            $this->setTypesAndBindings([$value]);

            if(!$this->isValidComparison($value, $comparison)) {
                throw new DatabaseException("Invalid comparison: {$comparison} {$value}");
            }

            $temp[] = $comparison == "IN"
                ? "{$column} IN (" . join(", ", array_fill(0, sizeof($value), '?')) . ")"
                : "{$column} {$comparison} ?";
        }

        return join(", ", $temp);
    }

    /**
     * @param $value
     * @param $comparison
     * @return bool
     */
    protected function isValidComparison($value, $comparison)
    {
        // most of our comparisons are in the form of X=Y, X<Y, etc.  none of these actually require any
        // testing.  therefore, the ones we focus on here are the LIKE and IN operators.  those need a
        // a little care.  regardless, we also pass $value to our setTypesAndBindings() method to be sure
        // they get updated, too.

        $okay = true;

        switch($comparison) {
            case "LIKE":
                $okay = strpos($value, "%") !== false;
                break;

            case "IN":
                $okay = is_array($value);
                break;
        }

        return $okay;
    }

    /**
     * @param array $parameters
     */
    protected function setTypesAndBindings(array $parameters)
    {
        // this method manipulates the types and bindings properties to be sure that we can bind our
        // parameters when executing our query. most of the time, each parameter is a scalar value so
        // we just need to determine they're type and cram them into the properties.  but, in cases
        // where we use an IN comparison (i.e. story_id IN (1,2,3)) we need to add each member of the
        // array to be sure things operate smoothly.  we can do that with a recursive call to this
        // function.

        foreach($parameters as $parameter) {
            if(is_array($parameter)) $this->setTypesAndBindings($parameter);
            else {
                // we assume that this parameter is a string first.  then, if it's numeric in any
                // way, we see if it's an integer or a floating point number.  unfortunately, since
                // this information is going to come to us as a PHP string, we can't use is_int()
                // because it'll always be false and, if we cast as (int), it'll always be true!

                $type = "s";
                if(is_numeric($parameter)) {
                    $type = floor($parameter)==$parameter ? "i" : "f";
                }

                $this->bindings[] = $parameter;
                $this->types[] = $type;
            }
        }
    }

    /**
     * resets our object in preparation for executing a query.
     */
    protected function resetQuery()
    {
        $this->bindings = [];
        $this->types = [];
    }
}