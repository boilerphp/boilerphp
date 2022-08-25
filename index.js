function Solution(A) {

    var max = 0;
    var min = 1;
    var middle = 0;
    var last = 0;
    var result = 0;

    for (let index = 0; index < A.length; index++) {

        if (A[index] > max)
            max = A[index];

        else if (A[index] <= min)
            min = A[index]

        else if (A[index] < max && A[index] > min)
            if (middle < A[index])
                middle = A[index]

        result = (max - middle) + min;
        last = A[index]
    }

    if (result <= 0) {
        result = 1
    }
    // console.log('Props', { min, max, middle, last })
    return result;
}

const findSmallestMissing = (arr = []) => {
    let count = 1;
    if (!arr?.length) {
        return count;
    };
    while (arr.indexOf(count) !== -1) {
        count++;
    };
    return count;
};
// console.log(findSmallestMissing(arr));

console.log(findSmallestMissing([1, 3, 4, 1, 3]), 'Expected: 2');
console.log(findSmallestMissing([-1, 3, -4]), 'Expected: 1');
console.log(findSmallestMissing([1, 4, 6, 5, 1, 3]), 'Expected: 2');
console.log(findSmallestMissing([1, 5, 6, 7, 3, 2]), 'Expected: 4')


import React, {useState, useEffect} from 'react';
import classnames from 'classnames';
// you should import `lodash` as a whole module
import lodash from 'lodash';
import axios from 'axios';

const ITEMS_API_URL = 'https://example.com/api/items';
const DEBOUNCE_DELAY = 500;

// the exported component can be either a function or a class

export default function Autocomplete({onSelectItem}) {

  const [items, setItems] = useState([]);
  const [query, setQuery] = useState('');
  const [loading, setLoading] = useState(false);

  useEffect(() => {
    const getList = setTimeout(() => {
      getItems()
    }, [DEBOUNCE_DELAY])

    return () => clearTimeout(getList)
  }, [query])

  async function getItems() {

    try {
      setLoading(true);
      
      var request = axios.get(ITEMS_API_URL + `?q=${query}`);
      var response = (await request).data;
      setItems(response);

      setLoading(false);
    } catch(error) {

    }
  } 

  return (
    <div className="wrapper">
      <div className="control">
        <input type="text" className={"input " + (loading ? 'is-loading' : '')} onChange={(e) => setQuery(e.target.value)} />
      </div>
      {
        items.length > 0 ? (
        <div className="list is-hoverable">
          {
            items.map((item, index) => (
              <a className="list-item" onClick={() => { onSelectItem(item) }}>{item}</a>
            ))
          }
        </div>
        ) : null
      }
    </div>
  );
}
